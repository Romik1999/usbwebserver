<?php

class Database
{

    private $host = "localhost";
    private $db_name = "test";
    private $username = "root";
    private $password = "usbw";
    private $charset = "utf8";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Ошибка соединения: " . $exception->getMessage();
        }
        
        return $this->conn;

    }
}
