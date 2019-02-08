<?php

return [
    'Qobo/Social' => [
        // Enable publishing posts to social networks
        'publishEnabled' => true,
        // List of registered publishers per social network name
        'publisher' => [
            'twitter' => 'Qobo\Social\Publisher\Twitter\TwitterPublisher',
        ],
    ]
];
