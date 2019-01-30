<?php
namespace Qobo\Social\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;

/**
 * SocialProvider shell command.
 *
 * @property \Qobo\Social\Shell\Task\ImportTask $Import
 */
class SocialProviderShell extends Shell
{

    /**
     * {@inheritDoc}
     */
    public $tasks = ['Qobo/Social.Import'];

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser(): ConsoleOptionParser
    {
        $parser = parent::getOptionParser();
        $parser->addSubcommand('import', [
            'help' => 'Import social feeds',
            'parser' => $this->Import->getOptionParser(),
        ]);

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null|void Success or error code.
     */
    public function main()
    {
        // dd($this->OptionParser);
        $this->out($this->getOptionParser()->help());
    }
}
