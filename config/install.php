<?php

return [

    /* Server Requirements */
    'php_version' => '8.2',

    'extensions' => [
        'php' => [
            'cURL',
            'Mbstring',
            'OpenSSL',
            'PDO',
            'Fileinfo',
            'JSON',
            'Tokenizer',
            'Ctype',
            'XML',
            'BCMath',
            'GD',
            'iconv'
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /* File permissions */
    'permissions' => [
        'Files' => [
            '.env',
        ],
        'Folders' =>
        [
            'lang',
            'storage',
            'bootstrap/cache',
            'public/storage/',
            'storage/framework',
            'storage/framework/cache',
            'storage/framework/cache/data',
            'storage/framework/sessions',
            'storage/framework/views',
            'storage/logs',
        ],
    ]
];
