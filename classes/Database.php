<?php
class Database {
    protected $conn;

    public function __construct(){
        $this->conn = new PDO(
            "mysql:host=localhost;dbname=projekti;charset=utf8mb4",
            "root",
            ""
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
