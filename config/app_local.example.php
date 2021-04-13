<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
         * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */

$dbHost = file_exists('/.dockerenv') ? '172.17.0.1' : 'localhost';

return [
    'Session' => [
        'timeout' => 1440,
    ],
    'App' => [
        'title' => 'Toggen WMS',
    ],
    // admin passwords if you use the seeds to create framework data

    'devPasswords' => [
        // role / password
        'admin' => 'admin',
        'user' => 'user',
        'qa' => 'qa',
        'qty_editor' => 'qty_editor'
    ],
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    // true for dev false for prod
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', 'replace this'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'host' => $dbHost,
            /*
             * CakePHP will use the default DB port based on the driver selected
             * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
             * the following line and set the port accordingly
             */
            //'port' => 'non_standard_port_number',

            'username' => 'your_db_user',
            'password' => 'your_db_pass',
            'database' => 'your_db',
            /**
             * If not using the default 'public' schema with the PostgreSQL driver
             * set it here.
             */
            //'schema' => 'myapp',

            /**
             * You can use a DSN string to set the entire configuration
             */
            // 'url' => env('DATABASE_URL', null),
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => $dbHost,
            //'port' => 'non_standard_port_number',
            'username' => 'your_test_db_user',
            'password' => 'your_test_db_pass',
            'database' => 'your_test_db',
            //'schema' => 'myapp',
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
        'AWS_SES' => [
            'className' => 'Smtp',
            'host' => 'email-smtp.ap-southeast-2.amazonaws.com',
            'port' => 587, // this is very important to be 587!! 
            'timeout' => 30,
            'username' => 'USERNAME',
            'password' => 'AWS_SES_KEY',
            'tls' => true, // this is also very important!!
            'log' => true
        ]
    ],
];
