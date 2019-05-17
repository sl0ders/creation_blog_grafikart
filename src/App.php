<?php


namespace App;

USE \PDO;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class App
{
    /**
     * PDO
     */
    private $pdo;
    public function __construct($isDev = false)
    {
        $this->isDev = $isDev;
        if ($isDev){
            define('DEBUG_TIME', microtime(true));
            $whoops = new Run;
            $whoops->pushHandler(new PrettyPageHandler);
            $whoops->register();
        }
    }

    public function getPDO(): PDO
    {
        if ($this->pdo === null) {
            return new PDO('mysql:dbname=tutoblog;host=127.0.0.1', 'root', '258790', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
        return $this->pdo;

    }
}