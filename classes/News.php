<?php
require_once __DIR__ . "/Database.php";

class News extends Database {

    public function add($title, $body, $image, $file, $createdBy) { // CREATE NEWS, INSERT INTO NEWS TABLE
        $stmt = $this->conn->prepare( //prepare command for insert into news table 
            "INSERT INTO news(title, body, image, file, created_by) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$title, $body, $image ?: null, $file ?: null, $createdBy]);
    }

    public function update($id, $title, $body, $image, $file, $updatedBy) { // update news 
        $stmt = $this->conn->prepare(
            "UPDATE news SET title = ?, body = ?, image = ?, file = ?, updated_by = ?, updated_at = NOW() WHERE id = ?"
        );
        return $stmt->execute([$title, $body, $image ?: null, $file ?: null, $updatedBy, $id]);
    }

    public function getById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT n.*, u1.name AS created_by_name, u2.name AS updated_by_name
                FROM news n
                LEFT JOIN users u1 ON n.created_by = u1.id
                LEFT JOIN users u2 ON n.updated_by = u2.id
                WHERE n.id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAll() { // read news from news table
        try {
            $stmt = $this->conn->query(
                "SELECT n.*, u1.name AS created_by_name, u2.name AS updated_by_name
                 FROM news n
                 LEFT JOIN users u1 ON n.created_by = u1.id
                 LEFT JOIN users u2 ON n.updated_by = u2.id
                 ORDER BY n.created_at DESC"
            );
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function delete($id) { // delete
        $stmt = $this->conn->prepare("DELETE FROM news WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
