<?php

class UserLogin
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function loginUser($userid, $password)
    {
        try {
            $sql = "SELECT * FROM utilisateur WHERE email = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                return "sqlerror";
            }

            $stmt->bindParam(1, $userid, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $pwdCheck = password_verify($password, $result["passwordUser"]);

                if (!$pwdCheck) {
                    return "nouser";
                }

                if ($result["idRole"] == "2") {
                    $this->handleClientLogin($result);
                } elseif ($result["idRole"] == "1") {
                    $this->handleAdminLogin($result);
                }
            } else {
                return "nouser";
            }
        } catch (PDOException $e) {
            // Log or handle the exception appropriately
            return "error";
        }
    }

    private function handleClientLogin($row)
    {
        $sql = "SELECT * FROM utilisateur
                JOIN panier ON utilisateur.idUser = panier.idUser
                WHERE utilisateur.email = ?";

        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bindParam(1, $row["email"], PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["panierId"] = $result['idPanier'];
            $_SESSION["client"] = "client";
            $_SESSION["userid"] = $result["idUser"];
            $_SESSION["useremail"] = $result["email"];

            header("Location: ../pages/index.php");
            exit();
        }
    }

    private function handleAdminLogin($row)
    {
        session_start();
        $_SESSION["admin"] = "admin";
        $_SESSION["username"] = $row["nom"];
        $_SESSION["useremail"] = $row["email"];
        header("Location: ../pages/dashboard.php");
        exit();
    }
}

// Usage example:

if (isset($_POST["login-submit"])) {
    require "../Config/config.php";
    $conn = Database::connexion();
    $userid = $_POST["userId"];
    $password = $_POST["password"];

    if (empty($userid) || empty($password)) {
        header("Location: ../pages/index.php?error=emptyfields");
        exit();
    } else {
        $userLogin = new UserLogin($conn);
        $result = $userLogin->loginUser($userid, $password);

        switch ($result) {
            case "nouser":
                header("Location: ../pages/index.php?error=nouser");
                exit();
            case "sqlerror":
                header("Location: ../pages/index.php?error=sqlerror");
                exit();
            case "error":
                // Handle other errors appropriately
                break;
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
