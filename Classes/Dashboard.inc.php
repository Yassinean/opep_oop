<?php
session_start();
require "../Config/config.php";
$conn = Database::connexion();
error_reporting(E_ALL);

class Dashboard
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function displayDashboard()
    {
        if (!$_SESSION['admin']) {
            header('Location: signup.php');
        }
    }
}