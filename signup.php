<?php
require "header.php";
require "User.php";
session_start();

if (isset($_POST['signup-submit'])) {
    $uid = $_POST['uid'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $pass_confirm = $_POST['password-repeat'];

    $error = validateSignup($uid, $email, $pass, $pass_confirm);

    if ($error) {
        $_SESSION['error'] = $error; // Store error in session
        header("Location: signup.php"); // Adjust the redirect as needed
        exit();
    }

    $user = new User();
    if ($user->userExists($email)) {
        $_SESSION['error'] = 'usertaken';
        header("Location: signup.php");
        exit();
    }

    $user->createUser($uid, $email, $pass);
    $_SESSION['signup_success'] = true;
    header("Location: signup.php");
    exit();
}
?>

?>

<form class="" action="../includes/signup.inc.php" method="post">
    <div class="form-signup">
        <h1 class="form-title">Sign Up</h1>
        <input type="text" name="uid" class="form-input" placeholder="Your Name" value="<?php echo isset($_GET['uid']) ? $_GET['uid'] : ''; ?>">
        <input type="text" name="email" class="form-input" placeholder="Email" value="<?php echo isset($_GET['email']) ?  $_GET['email'] : "" ?>">
        <input type="password" name="password" class="form-input" placeholder="Password">
        <input type="password" name="password-repeat" class="form-input" placeholder="Repeat Password">
        <button type="submit" name="signup-submit" class="form-button">suivant</button>
        <?php
        function validateSignup($uid, $email, $pass, $pass_confirm)
        {
            if (empty($uid) || empty($email) || empty($pass) || empty($pass_confirm)) {
                return 'emptyfields';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]$/", $uid)) {
                return 'invalidemailUid';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 'invalidemail';
            }

            if (!preg_match("/^[a-zA-Z0-9]$/", $uid)) {
                return 'invaliduid';
            }

            if ($pass !== $pass_confirm) {
                return 'passwordcheck';
            }

            return '';
        }
        ?>
    </div>
</form>