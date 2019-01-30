<?php
namespace Qobo\Social\Shell\Helper;

use Cake\Console\Helper;

/**
 * ArrayOptions shell helper.
 */
class ArrayOptionsHelper extends Helper
{
    protected $_defaultConfig = [
        'params' => [],
    ];

    /**
     * {@inheritDoc}
     */
    public function output($args)
    {
    }

    /**
     * Initialize the helper.
     *
     * Set the `params` (options) to your shell/task's options.
     *
     * @param mixed[] $options Options
     * @return void
     */
    public function init(array $options = []): void
    {
        $this->setConfig($options);
    }

    /**
     * Returns a processed `config` option.
     *
     * @param string $option Option name.
     * @return mixed[]
     */
    public function get(string $option): array
    {
        $params = $this->getConfig('params');
        $config = $params[$option] ?? [];
        $result = [];
        foreach ($config as $option) {
            $parsed = explode('=', $option, 2);
            if (count($parsed) === 1) {
                $result[] = $parsed[0];
            } else {
                $result[$parsed[0]] = $parsed[1];
            }
        }

        return $result;
    }
}
