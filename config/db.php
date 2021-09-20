<?php
// $env = @parse_ini_file('../.env', true);

// $host = '127.0.0.1';
// $port = '3306';
// $db = 'evermos-db';
// $username = 'root';
// $password = 'root';

// if ($env) {
//     $host = @$env['database']['host'] ? : $host; 
//     $port = @$env['database']['port'] ? : $port; 
//     $db = @$env['database']['db'] ? : $db; 
//     $username = @$env['database']['username'] ? : $username; 
//     $password = @$env['database']['password'] ? : $password; 
// }

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=evermos-test-db',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    // 'schemaMap' => [
    //     'mysql' => [
    //       'class' => 'yii\db\mysql\Schema',
    //       'defaultSchema' => 'public'
    //     ]
    // ],

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
