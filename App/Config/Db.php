<?php

namespace Config;

/**
 *
 */
class Db
{
    public $db_connect;
    public static $instance;
    private $host = 'localhost';
    private $db_user = 'root';
    private $db_user_pass = '';
    private $db_name = 'oop';

    function __construct()
    {
        $this->db_connect = new \mysqli($this->host, $this->db_user, $this->db_user_pass, $this->db_name);

        if ($this->db_connect->connect_error) {
            die('Could not connect to database!');
        } else {
            self::$instance = $this->db_connect;
        }
    }

    static function connect()
    {
        self::$instance = self::$instance ? self::$instance : new self();
        return self::$instance;
    }
}
