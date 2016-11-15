<?php

class DbConnector
{

    private $conn;

    public function __construct()
    {

        $servername = "192.168.20.56";
        $dbname = "parkingSystem";
        $username = "root";
        $password = "";

        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        } catch (Exception $e) {
            throw new Exception('error connecting to database');
        }
    }

    public function getDB(){
        return $this->conn;
    }
}

