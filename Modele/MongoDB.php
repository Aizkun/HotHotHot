<?php

use \MongoClient;
final class MongoDB extends PDO
{

    private const DBHOST = '127.0.0.1:27017';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBAUTH = 'admin';
    private $connection;

    /**
     * @throws MongoConnectionException
     */
    public function __construct()
    {
        $serverString = "mongodb://";

        $serverString .= self::DBUSER . ":" . self::DBPASS . "@" . self::DBHOST . "/" . self::DBAUTH;

        $this->connection = new \MongoClient($serverString);
    }
}