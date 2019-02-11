<?php
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Qobo\Social\Event\Twitter\ConnectTwitterAccountListener;

/**
 * Plugin configuration
 */
// get app level config
$config = Configure::read('Qobo/Social');
$config = $config ? $config : [];

// load default plugin config
Configure::load('Qobo/Social.encrypt');
Configure::load('Qobo/Social.publisher');

// overwrite default plugin config by app level config
Configure::write('Qobo/Social', array_replace_recursive(
    Configure::read('Qobo/Social'),
    $config
));

EventManager::instance()->on(new ConnectTwitterAccountListener());
