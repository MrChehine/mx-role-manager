<?php

require 'vendor/autoload.php';

$env = \Dotenv\Dotenv::createImmutable('/app');
$env->load();
//var_dump($_ENV);
echo dirname(__DIR__);
echo getenv('DB_HOST') ?? 'null';
echo $_ENV['DB_HOST'];
echo "\n
";