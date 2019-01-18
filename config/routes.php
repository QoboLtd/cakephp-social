<?php
use Cake\Routing\Router;

Router::plugin(
    'Qobo/Social',
    ['path' => '/social'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
