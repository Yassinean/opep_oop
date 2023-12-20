<?php

if (isset($_POST["role-submit"])) {
    require "dbh.inc.php";
    require "UserRole.php";

    $role = $_POST["role"];
    session_start();
    $id = $_SESSION["userid"];

    if (empty($role)) {
        header("Location: ../pages/role.php?error=emptyfields");
        exit();
    }

    $userRole = new UserRole();

    if (!$userRole->assignRole($id, $role)) {
        header("Location: ../pages/role.php?error=sqlerror");
        exit();
    }

    if ($role == "1") {
        $_SESSION["admin"] = "admin";
        $userInfo = $userRole->getUserById($id);
        $_SESSION["name"] = $userInfo["nom"];
        header("Location: ../pages/dashboard.php");
        exit();
    } else if ($role == "2") {
        $panierId = $userRole->createPanierForUser($id);
        $_SESSION["panierId"] = $panierId;
        $_SESSION["client"] = "client";
        $_SESSION["idUser"] = $id;
        $_SESSION["useremail"] = $userInfo["email"];
        header("Location: ../pages/index.php");
        exit();
    }
} else {
    header("Location: ../pages/signup.php?");
    exit();
}

?>




<form action="../includes/role.inc.php" method="post">
    <div class="form-signup">
        <h1 class="form-title">Sign Up</h1>
        <select name="role" class="choix">
            <option value="1">Admin</option>
            <option value="2">Client</option>
        </select>
        <button type="submit" name="role-submit" class="form-button">sign up</button>
    </div>
</form>