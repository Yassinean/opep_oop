<?php

class CategoryManagement
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addCategory($nomCateg)
    {
        try {
            $sql = "INSERT INTO categorie (nomCategorie) VALUES (?)";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                return "sqlerror";
            }

            $stmt->bindParam(1, $nomCateg, PDO::PARAM_STR);

            $stmt->execute();

            return "success";
        } catch (PDOException $e) {
            // Log or handle the exception appropriately
            return "error";
        }
    }

    public function getCategoriesWithPlantCount()
    {
        $categoriesWithPlantCount = array();

        $sql = "SELECT categorie.*, COUNT(plante.idPlante) AS plantCount FROM categorie LEFT JOIN plante ON categorie.idCategorie = plante.idCategorie GROUP BY categorie.idCategorie";
        $stmt = $this->conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoriesWithPlantCount[] = $row;
        }

        return $categoriesWithPlantCount;
    }
}

// Usage example:

$categoryManagement = new CategoryManagement(Database::connexion());

// Fetch categories with plant count
$categoriesWithPlantCount = $categoryManagement->getCategoriesWithPlantCount();
