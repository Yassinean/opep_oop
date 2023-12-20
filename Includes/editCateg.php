<?php

require "../Config/config.php";
$conn = Database::connexion();

class editCateg
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function editCategory($id, $nomCategEdit)
    {
        if (empty($nomCategEdit)) {
            return "emptyFields";
        }

        $sql = 'UPDATE categorie SET nomCategorie = ? WHERE idCategorie = ?';
        $stmt = mysqli_stmt_init($this->conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return "sqlerror";
        }

        mysqli_stmt_bind_param($stmt, "si", $nomCategEdit, $id);
        mysqli_stmt_execute($stmt);

        return "success";
    }
}

// Usage example:

if (isset($_POST['editCateg'])) {
    $id = $_POST['id'];
    $nomCategEdit = $_POST['nomCategEdit'];

    $editCateg = new editCateg($conn);
    $result = $editCateg->editCategory($id, $nomCategEdit);

    switch ($result) {
        case "emptyFields":
            header("Location: ../pages/modifierCateg.php?error=emptyFields");
            exit();
        case "sqlerror":
            header("Location: ../pages/dashboard.php?error=sqlerror");
            exit();
        case "success":
            header("Location: ../pages/dashboard.php?success=updated");
            exit();
        default:
            // Handle unexpected result
            break;
    }
}
