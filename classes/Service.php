<?php
class Service
{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM services ORDER BY id ASC");
    }

    public function getByName($service_name) {
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE service_name = ? LIMIT 1");
        $stmt->bind_param("s", $service_name);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows ? $res->fetch_assoc() : null;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows ? $res->fetch_assoc() : null;
    }

    public function create($service_name, $image, $price, $description, $best_for) {
        // Ensure price is always a float
        $price = isset($price) && $price !== '' ? floatval($price) : 0;

        $stmt = $this->conn->prepare("
            INSERT INTO services (service_name, image, price, description, best_for)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssdss", $service_name, $image, $price, $description, $best_for);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $old = $this->getById($id);
        if (!$old) return false;

        $service_name = isset($data['service_name']) ? $data['service_name'] : $old['service_name'];
        $image        = isset($data['image']) ? $data['image'] : $old['image'];
        $price        = isset($data['price']) ? $data['price'] : $old['price'];
        $description  = isset($data['description']) ? $data['description'] : $old['description'];
        $best_for     = isset($data['best_for']) ? $data['best_for'] : $old['best_for'];

        $stmt = $this->conn->prepare("
            UPDATE services
            SET service_name=?, image=?, price=?, description=?, best_for=?
            WHERE id=?
        ");
        $stmt->bind_param("ssdssi", $service_name, $image, $price, $description, $best_for, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
