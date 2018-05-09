<?php

class dbHelper
{
    public function __construct()
    {
        $db_ip = "localhost";
        $db_username = "root";
        $db_pass = "";
        $db_name = "portfolio";

        try {
            $this->conn = new PDO("mysql: host=$db_ip;dbname=$db_name", $db_username, $db_pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function getFromDb($query)
    {
        return $this->conn->query($query);
    }
}