<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DatabaseConf.conf.php';

class Database {

    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . DatabaseConf::$host . ';dbname=' . DatabaseConf::$db_name,
            DatabaseConf::$username, DatabaseConf::$password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>