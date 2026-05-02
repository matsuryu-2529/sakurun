<?php

foreach ([
    'APP_ENV' => 'testing',
    'BCRYPT_ROUNDS' => '4',
    'CACHE_DRIVER' => 'array',
    'DB_CONNECTION' => 'mysql',
    'MAIL_MAILER' => 'array',
    'PULSE_ENABLED' => 'false',
    'QUEUE_CONNECTION' => 'sync',
    'SESSION_DRIVER' => 'array',
    'TELESCOPE_ENABLED' => 'false',
] as $name => $value) {
    $_SERVER[$name] = $value;
    $_ENV[$name] = $value;
    putenv("{$name}={$value}");
}

require __DIR__ . '/../vendor/autoload.php';
