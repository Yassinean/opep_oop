<?php

require_once '../Config/config.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function validateSignup($name, $email, $password, $repeatedPassword)
    {
        if (empty($name) || empty($email) || empty($password) || empty($repeatedPassword)) {
            return ['error' => 'emptyfields'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z\s]+$/", $name)) {
            return ['error' => 'invalidemailUid'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'invalidemail', 'uid' => $name];
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $name)) {
            return ['error' => 'invaliduid', 'email' => $email];
        }

        if ($password !== $repeatedPassword) {
            return ['error' => 'passwordcheck', 'uid' => $name, 'email' => $email];
        }

        return [];
    }

    public function userExists($email)
    {
        $sql = "SELECT email FROM utilisateur WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function createUser($name, $email, $password)
    {
        $sql = "INSERT INTO utilisateur (nom, email, passwordUser, idRole) VALUES (?, ?, ?, NULL)";
        $stmt = $this->db->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        $stmt->execute();

        return $this->db->insert_id;
    }
}

// Usage
if (isset($_POST["signup-submit"])) {
    $user = new User();
    $validationResult = $user->validateSignup($_POST["uid"], $_POST["email"], $_POST["password"], $_POST["password-repeat"]);

    if (!empty($validationResult)) {
        $errorQuery = http_build_query($validationResult);
        header("Location: ../pages/signup.php?{$errorQuery}");
        exit();
    }

    if ($user->userExists($_POST["email"])) {
        header("Location: ../pages/signup.php?error=usertaken&uid=" . $_POST["uid"]);
        exit();
    }

    $lastInsertedID = $user->createUser($_POST["uid"], $_POST["email"], $_POST["password"]);
    session_start();
    $_SESSION["userid"] = $lastInsertedID;
    header("Location: ../pages/role.php");
    exit();
} else {
    header("Location: ../pages/signup.php?");
    exit();
}
