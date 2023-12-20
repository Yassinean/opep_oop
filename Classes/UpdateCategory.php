<?php

require "../Config/config.php";
// $conn = Database::connexion();
class CategoryUpdate
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function updateCategory($id, $nomCategEdit)
    {
        try {
            $sql = 'UPDATE categorie SET nomCateorie = ? WHERE idCategorie = ?';
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                return "sqlerror";
            }

            $stmt->bindParam(1, $nomCategEdit, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);

            $stmt->execute();

            return "success";
        } catch (PDOException $e) {
            // Log or handle the exception appropriately
            return "error";
        }
    }
}

// Usage example:

$categoryUpdate = new CategoryUpdate($conn);

if (isset($_POST['editCateg'])) {
    $nomCategEdit = $_POST['nomCategEdit'];
    $id = $_POST['id'];

    if (empty($nomCategEdit)) {
        header("Location: ../pages/modifierCateg.php?error=emptyFields");
        exit();
    } else {
        $result = $categoryUpdate->updateCategory($id, $nomCategEdit);

        if ($result === "success") {
            header("Location: ../pages/dashboard.php?success=updated");
            exit();
        } else {
            header("Location: ../pages/dashboard.php?error=sqlerror");
            exit();
        }
    }
}
