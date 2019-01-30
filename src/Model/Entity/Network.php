<?php
namespace Qobo\Social\Model\Entity;

use Cake\ORM\Entity;
use InvalidArgumentException;
use Qobo\Social\Provider\ProviderInterface;
use Qobo\Social\Provider\ProviderRegistry;

/**
 * Network Entity
 *
 * @property string $id
 * @property string $title
 * @property string $name
 * @property string $url
 * @property string $oauth_consumer_key
 * @property string $oauth_consumer_secret
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime|null $trashed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Qobo\Social\Model\Entity\Account[] $accounts
 */
class Network extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Returns a social provider.
     *
     * @param string $providerName Provider name.
     * @return \Qobo\Social\Provider\ProviderInterface Provider object.
     */
    public function getSocialProvider(string $providerName): ProviderInterface
    {
        $registry = ProviderRegistry::getInstance();
        if (!$registry->exists($this->name, $providerName)) {
            throw new InvalidArgumentException("`{$providerName}` is not a valid social provider.");
        }

        $provider = $registry->get($this->name, $providerName);
        $provider->setCredentials($this->oauth_consumer_key, $this->oauth_consumer_secret);
        $provider->setNetwork($this);

        return $provider;
    }
}
