<?php

/**
 * Array of IP addresses that are allowed to see debug information. To add more separate each entry
 * by a comma and enclose in double or single quotes. Only IPv4 Addressed supported.
 * Default: 127.0.0.1 (localhost)
 *
 * @var array
 */
$allowedIps = ['127.0.0.1'];

if (isset($_SERVER['REMOTE_ADDR'])) {
    // Check for cloudflare use
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if (in_array($ip, $allowedIps)) {
        $debug = true;
    } else {
        $debug = false;
    }
} else {
    $debug = false;
}

/**
 * If Memcached exists then use that instead for better performance.
 * Supported: "file", "database", "apc", "memcached", "redis", "array"
 */
if (class_exists('Memcached')) {
    $session_driver = 'memcached';
    $cache_driver = 'memcached';
} else {
    $session_driver = 'file';
    $cache_driver = 'file';
}

return [

    /**
     * Do not change these settings unless
     * you know what you're doing
     */
    'APP_ENV' => 'production',
    'APP_DEBUG' => $debug,
    'IP_WHITELIST' => implode('|', $allowedIps),
    'SESSION_DRIVER' => $session_driver,
    'CACHE_DRIVER' => $cache_driver,
    /**
     * Database Settings
     */
    'DB_HOST' => getenv('DB_HOST'),
    'DB_USER' => getenv('DB_USER'),
    'DB_PASS' => getenv('DB_PASS'),
    'DB_NAME' => getenv('DB_NAME'),
    /**
     * Set your app key here
     */
    'APP_KEY' => getenv('APP_KEY'),
    /**
     * Set pusher API keys to allow realtime functionality. You will need to create an account.
     *
     * See https://pusher.com/docs/javascript_quick_start
     */
    'PUSHER_APP_ID' => getenv('PUSHER_APP_ID'),
    'PUSHER_APP_KEY' => getenv('PUSHER_APP_KEY'),
    'PUSHER_APP_SECRET' => getenv('PUSHER_APP_SECRET'),
    
    /**
     * Email Settings
     */
    'MAIL_DRIVER' => 'smtp',
    'MAIL_HOST' => 'smtp.mailtrap.io',
    'MAIL_PORT' => 2525,
    'MAIL_USERNAME' => '',
    'MAIL_PASSWORD' => '',
    'MAIL_FROM_ADDRESS' => '',
    'MAIL_FROM_NAME' => '',
    'MAIL_ENCRYPTION' => 'tls,
];
