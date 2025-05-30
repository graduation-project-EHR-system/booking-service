<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kafka Brokers
    |--------------------------------------------------------------------------
    |
    | The Kafka brokers where your application will connect to.
    |
    */
    'brokers'           => env('KAFKA_BROKERS', 'localhost:9092'),

    /*
    |--------------------------------------------------------------------------
    | Kafka Consumer Group
    |--------------------------------------------------------------------------
    |
    | The default consumer group for your application.
    |
    */
    'consumer_group_id' => env('KAFKA_CONSUMER_GROUP_ID', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Auto Commit
    |--------------------------------------------------------------------------
    |
    | Whether to automatically commit offsets after processing messages.
    |
    */
    'auto_commit'       => env('KAFKA_AUTO_COMMIT', true),

    /*
    |--------------------------------------------------------------------------
    | Kafka Security Protocol
    |--------------------------------------------------------------------------
    |
    | The security protocol to use when connecting to Kafka.
    | Options: plaintext, ssl, sasl_plaintext, sasl_ssl
    |
    */
    'security_protocol' => env('KAFKA_SECURITY_PROTOCOL', 'plaintext'),

    /*
    |--------------------------------------------------------------------------
    | Kafka SASL
    |--------------------------------------------------------------------------
    |
    | The SASL configuration for Kafka authentication.
    |
    */
    'sasl'              => [
        'mechanisms' => env('KAFKA_SASL_MECHANISMS', 'PLAIN'),
        'username'   => env('KAFKA_SASL_USERNAME', ''),
        'password'   => env('KAFKA_SASL_PASSWORD', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Kafka SSL
    |--------------------------------------------------------------------------
    |
    | The SSL configuration for Kafka.
    |
    */
    'ssl'               => [
        'ca_location'          => env('KAFKA_SSL_CA_LOCATION', ''),
        'certificate_location' => env('KAFKA_SSL_CERTIFICATE_LOCATION', ''),
        'key_location'         => env('KAFKA_SSL_KEY_LOCATION', ''),
        'key_password'         => env('KAFKA_SSL_KEY_PASSWORD', ''),
    ],
];
