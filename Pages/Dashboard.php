<?php

require_once '../Classes/Dashboard.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-info {
            background-color: #5bc0de;
            color: #fff;
        }

        .btn-add {
            background-color: #040;
            color: #fff;
        }

        .btn-danger {
            background-color: #d9534f;
            color: #fff;
        }

        form.form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .form input,
        .form select,
        .form button {
            flex: 1;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 10px;
        }

        .form button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        .form button:hover {
            background-color: #45a049;
        }

        .modal {
            position: fixed;
            display: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .btn#close {
            margin: 10px;

        }

        .box h1 {
            text-align: center;
            margin: 10px 0 30px;
            /* font-size: ; */
        }
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="./dashboard.php">
                        <span class="icon">
                            <ion-icon name="rose-outline"></ion-icon>
                        </span>
                        <span class="title">O-PEP</span>
                    </a>
                </li>
                <li>
                    <a href="#plantes">
                        <span class="icon">
                            <ion-icon name="leaf-outline"></ion-icon>
                        </span>
                        <span class="title">plantes</span>
                    </a>
                </li>
                <li>
                    <a href="#categories">
                        <span class="icon">
                            <ion-icon name="sync"></ion-icon>
                        </span>
                        <span class="title">categories</span>
                    </a>
                </li>
                <li>
                    <a href="../includes/logout.inc.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class='title'>logout</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="details" id="plantes">
            <?php require_once '../Classes/PlanteManagement.php'; ?>
            <div class="box">
                <h1>Gestion des plantes</h1>
                <?php  // Fetch categories
                $categories = $planteManagement->getCategories();

                // Fetch plants
                $plantes = $planteManagement->getPlantes();
                ?>
                <form class="form" action="../includes/ajouter.inc.php" method="post" enctype="multipart/form-data">
                    <input name="nomPlante" type="text" placeholder="nom">
                    <input name="pricePlante" type="number" placeholder="prix">
                    <input name="imagePlante" type="file">
                    <select name="catPlante" id="">
                        <?php foreach ($categories as $row) : ?>
                            <option value="<?php echo $row['idCategorie']; ?>">
                                <?php echo $row['nomCategorie']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-add" name="ajouterPlante">
                        Ajouter plante
                    </button>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Image</th>
                            <th>Catégorie</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <?php  $plantesWithCategories = $planteManagement->getPlantes();
                            foreach ($plantesWithCategories as $row) : 
                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $row['idPlante']; ?></td>
                            <td style="text-align: center;"><?php echo $row['nom']; ?></td>
                            <td style="text-align: center;"><?php echo $row['prix']; ?></td>
                            <td style="text-align: center;">
                                <img src="../uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['image']; ?>" style="width: 200px; border-radius: 10px;">
                            </td>
                            <td style="text-align: center;"><?php echo $row['nomCategorie']; ?></td>
                            <td style="text-align: center;">
                                <a class="btn btn-info" href="./modifierPlante.php?id=<?php echo $row['idPlante']; ?>">Modifier</a>
                                <a class="btn btn-danger" href="../includes/deletePlante.inc.php?id=<?php echo $row['idPlante']; ?>">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="details" id="categories">
            <?php require_once '../Classes/CategoryManagement.php'; ?>
            <div class="box">
                <div class="">
                    <h1>Gestion des catégories</h1>
                    <form class="form" action="../includes/ajouterCateg.inc.php" method="post">
                        <input name="nomCateg" type="text" placeholder="nom">
                        <button class="btn btn-add" name="ajouterCateg">
                            Ajouter catégorie
                        </button>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Nombre de plantes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php foreach ($categoriesWithPlantCount as $row) : ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $row['idCategorie']; ?></td>
                                    <td style="text-align: center;"><?php echo $row['nomCategorie']; ?></td>
                                    <td style="text-align: center;"><?php echo $row['plantCount']; ?></td>
                                    <td style="text-align: center;">
                                        <a class="btn btn-info" href="../Pages/modifierCateg.php?id=<?php echo $row['idCategorie']; ?>">Modifier</a>
                                        <a class="btn btn-danger" href="../includes/deleteCateg.inc.php?id=<?php echo $row['idCategorie']; ?>">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- =========== Scripts =========  -->
        <script src="../assets/js/main.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();

                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            window.scrollTo({
                                top: targetElement.offsetTop - 0, // Adjust the offset as needed
                                behavior: 'smooth'
                            });
                        }
                    });
                });
            });
        </script>
        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </div>
</body>
</html>