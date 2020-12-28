<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=192.168.100.17;dbname=template',
    'username' => 'test3',
    'password' => 'test3',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];
