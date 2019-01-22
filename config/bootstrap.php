<?php
use Cake\Core\Configure;

/**
 * Plugin configuration
 */
// get app level config
$config = Configure::read('Qobo/Social');
$config = $config ? $config : [];

// load default plugin config
Configure::load('Qobo/Social.encrypt');

// overwrite default plugin config by app level config
Configure::write('Qobo/Social', array_replace_recursive(
    Configure::read('Qobo/Social'),
    $config
));
