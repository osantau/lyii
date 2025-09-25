<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=lyii',
    'username' =>'lyii',
    'password' => 'Parola1234',
    'charset' => 'utf8',
    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
      'attributes' => [
            PDO::ATTR_PERSISTENT => true, // Persistent connection
        ],
];
