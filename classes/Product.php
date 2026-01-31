<?php
require_once __DIR__ . "/Database.php";

class Product extends Database {

    public function add($title, $description, $image, $file, $createdBy) {
        $stmt = $this->conn->prepare(
            "INSERT INTO products(title, description, image, file, created_by) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$title, $description, $image ?: null, $file ?: null, $createdBy]);
    }

    public function update($id, $title, $description, $image, $file, $updatedBy) {
        $stmt = $this->conn->prepare(
            "UPDATE products SET title = ?, description = ?, image = ?, file = ?, updated_by = ?, updated_at = NOW() WHERE id = ?"
        );
        return $stmt->execute([$title, $description, $image ?: null, $file ?: null, $updatedBy, $id]);
    }

    public function getById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT p.*, u1.name AS created_by_name, u2.name AS updated_by_name
                FROM products p
                LEFT JOIN users u1 ON p.created_by = u1.id
                LEFT JOIN users u2 ON p.updated_by = u2.id
                WHERE p.id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAll() {
        try {
            $stmt = $this->conn->query(
                "SELECT p.*, u1.name AS created_by_name, u2.name AS updated_by_name
                 FROM products p
                 LEFT JOIN users u1 ON p.created_by = u1.id
                 LEFT JOIN users u2 ON p.updated_by = u2.id
                 ORDER BY p.created_at DESC"
            );
            return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
