<?php

require_once 'Database.php'; // Assuming this is your Database class file

class UserRole
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function assignRole($userId, $roleId)
    {
        $sql = "UPDATE utilisateur SET idRole = ? WHERE idUser = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $roleId, $userId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM utilisateur WHERE idUser = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function createPanierForUser($userId)
    {
        $sql = "INSERT INTO panier (idUser) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        return $this->db->insert_id;
    }
}
