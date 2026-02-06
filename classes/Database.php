<?php
class Database {
    protected $conn; // ENCAPSULATION OF THE DATABASE CONNECTION

    public function __construct(){
        $this->conn = new PDO(
            "mysql:host=localhost;dbname=projekti;charset=utf8mb4",
            "root",
            ""
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
