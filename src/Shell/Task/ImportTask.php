<?php
namespace Qobo\Social\Shell\Task;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Core\Configure;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;
use InvalidArgumentException;
use Qobo\Social\Model\Entity\Network;
use Qobo\Social\Model\Entity\Topic;
use Qobo\Social\Provider\ProviderInterface;
use Qobo\Social\Provider\TopicProviderInterface;

/**
 * Import shell task.
 *
 * @property \Qobo\Social\Model\Table\NetworksTable $Networks
 * @property \Qobo\Social\Model\Table\TopicsTable $Topics
 */
class ImportTask extends Shell
{
    use LogTrait;

    /**
     * Array Options helper
     * @var \Qobo\Social\Shell\Helper\ArrayOptionsHelper
     */
    protected $ArrayOptions;

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        parent::initialize();

        // Disable publishing to avoid duplicating posts back to social network
        Configure::write('Qobo/Social.publishEnabled', false);

        $this->loadModel('Qobo/Social.Networks');
        $this->loadModel('Qobo/Social.Topics');
        /** @var \Qobo\Social\Shell\Helper\ArrayOptionsHelper $helper */
        $helper = $this->helper('Qobo/Social.ArrayOptions');
        $this->ArrayOptions = $helper;
    }

    /**
     * Configure option parser
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser(): ConsoleOptionParser
    {
        $parser = parent::getOptionParser();
        $parser->setDescription('Imports the social feed from a social provider.');
        $parser->addArgument('network', [
            'help' => 'Social network name.',
            'required' => true
        ])->addArgument('provider', [
            'help' => 'Provider name.',
            'required' => true
        ])->addArgument('topic', [
            'help' => 'Topic name.',
            'required' => false
        ])->addOption('config', [
            'short' => 'c',
            'help' => 'Parser config',
            'multiple' => true,
        ]);

        return $parser;
    }

    /**
     * Import social posts task.
     *
     * Use the `-c|--config` switch to pass array config to the provider like so:
     * ./bin/cake social_provider import twitter sandbox-dev "My Topic" -c "key1=value2" -c "key2=value2"
     *
     * @param string $networkName Network name.
     * @param string $providerName Provider name.
     * @param null|string $topicUuid Optional topic.
     * @return void
     */
    public function main(string $networkName, string $providerName, ?string $topicUuid = null)
    {
        $provider = $this->findNetworkProvider($networkName, $providerName);

        /** @var null|\Qobo\Social\Model\Entity\Topic $topic */
        $topic = null;
        if ($provider instanceof TopicProviderInterface) {
            if (!empty($topicUuid)) {
                $topic = $this->getTopic($topicUuid);
                $provider->setTopic($topic);
            }
        }

        // Process multiple config option into a single array
        $this->ArrayOptions->init(['params' => $this->params]);
        $config = $this->ArrayOptions->get('config');

        // Query twitter api and get back an array of posts
        $response = $provider->read($config);
        $posts = $response->getPosts();
        $table = TableRegistry::getTableLocator()->get('Qobo/Social.Posts');

        $total = count($posts);
        /** @var \Cake\Shell\Helper\ProgressHelper $progress */
        $progress = $this->getIo()->helper('Progress');
        $progress->init([
            'total' => $total,
            'width' => 50,
        ]);
        foreach ($posts as $post) {
            if ($topic !== null) {
                $post = $table->patchEntity($post, [
                    'topics' => [
                        ['id' => $topic->get('id')]
                    ]
                ], ['validate' => false]);
            }
            if (!$table->save($post)) {
                $this->err('Error saving social post: ' . $post->get('external_post_id'));
            }
            $progress->increment(1);
            $progress->draw();
        }

        $this->out('');
        $this->out('Complete!');
    }

    /**
     * Find the network entity by name.
     *
     * @param string $name Network name.
     * @return \Qobo\Social\Model\Entity\Network
     */
    protected function findNetwork(string $name): Network
    {
        /** @var null|\Qobo\Social\Model\Entity\Network $network */
        $network = $this->Networks->find('decrypt')->where(['name' => $name])->first();
        if ($network === null) {
            $this->abort("Network `{$name}` is not defined in the system.");
        }

        return $network;
    }

    /**
     * Find the network provider.
     *
     * @param string $networkName Network name.
     * @param string $providerName Provider name.
     * @return \Qobo\Social\Provider\ProviderInterface
     */
    protected function findNetworkProvider(string $networkName, string $providerName): ProviderInterface
    {
        $network = $this->findNetwork($networkName);

        try {
            $provider = $network->getSocialProvider($providerName);
        } catch (InvalidArgumentException $e) {
            $this->abort($e->getMessage());
        }

        return $provider;
    }

    /**
     * Find the topic entity.
     *
     * @param string $uuid Topic uuid.
     * @return \Qobo\Social\Model\Entity\Topic
     */
    protected function getTopic(string $uuid): Topic
    {
        /** @var \Qobo\Social\Model\Entity\Topic $topic */
        try {
            $topic = $this->Topics->get($uuid, [
                'contain' => ['Keywords'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->abort("Topic `{$uuid}` is not defined in the system.");
        }

        return $topic;
    }
}
