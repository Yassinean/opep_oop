<?php

                class PlanteManagement
                {
                    private $conn;

                    public function __construct($conn)
                    {
                        $this->conn = $conn;
                    }

                    public function addPlante($nom, $prix, $image, $idCategorie)
                    {
                        try {
                            $sql = "INSERT INTO plante (nom, prix, image, idCategorie) VALUES (?, ?, ?, ?)";
                            $stmt = $this->conn->prepare($sql);

                            if (!$stmt) {
                                return "sqlerror";
                            }

                            $stmt->bindParam(1, $nom, PDO::PARAM_STR);
                            $stmt->bindParam(2, $prix, PDO::PARAM_INT);
                            $stmt->bindParam(3, $image, PDO::PARAM_STR);
                            $stmt->bindParam(4, $idCategorie, PDO::PARAM_INT);

                            $stmt->execute();

                            return "success";
                        } catch (PDOException $e) {
                            // Log or handle the exception appropriately
                            return "error";
                        }
                    }

                    public function getCategories()
                    {
                        $categories = array();

                        $sql = "SELECT * FROM categorie";
                        $stmt = $this->conn->query($sql);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $categories[] = $row;
                        }

                        return $categories;
                    }

                    public function getPlantes()
                    {
                        $plantes = array();

                        $sql = "SELECT plante.*, categorie.nomCategorie FROM plante JOIN categorie ON plante.idCategorie = categorie.idCategorie";
                        $stmt = $this->conn->query($sql);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $plantes[] = $row;
                        }

                        return $plantes;
                    }
                }
                $planteManagement = new PlanteManagement(Database::connexion());

                if (isset($_POST["ajouterPlante"])) {
                    $nom = $_POST["nomPlante"];
                    $prix = $_POST["pricePlante"];
                    $image = $_FILES["imagePlante"]["name"];
                    $idCategorie = $_POST["catPlante"];

                    // Add plant
                    $result = $planteManagement->addPlante($nom, $prix, $image, $idCategorie);

                    switch ($result) {
                        case "success":
                            // Handle success
                            break;
                        case "sqlerror":
                            // Handle SQL error
                            break;
                        case "error":
                            // Handle other errors
                            break;
                    }
                }

                // Fetch categories
                $categories = $planteManagement->getCategories();

                // Fetch plants
                $plantes = $planteManagement->getPlantes();
                ?>