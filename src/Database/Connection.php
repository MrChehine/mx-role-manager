<?php

namespace MxRoleManager\Database;

use MxRoleManager\Config\ConfigLoader;

class Connection
{
    private static ?\PDO $pdo = null;

    private function __construct(string $hostname, string $port, string $dbname, string $username, string $password)
    {
        $dsn = "mysql:host=$hostname;port=$port;dbname=$dbname";
        try {
            $pdo = new \PDO($dsn, $username, $password);
            self::$pdo = $pdo;
        } 
        catch (\Exception $exception)
        {
            self::$pdo = null;    
        }
    }

    public static function getPdo() : ?\PDO
    {
        if(self::$pdo == null)
        {
            $hostname = ConfigLoader::getDatabaseHost();
            $port     = ConfigLoader::getDatabasePort();
            $dbname   = ConfigLoader::getDatabaseName();
            $username = ConfigLoader::getDatabaseUsername();
            $password = ConfigLoader::getDatabasePassword();
            new self($hostname,$port,$dbname,$username,$password);
        }
        return self::$pdo;
    }
}