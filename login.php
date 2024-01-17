<?php
include 'auth_functions.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $authResult = authenticateUser($email, $password);


    if ($authResult['success']) {
        if ($authResult['role'] === 'admin') {
            setcookie("loggedInAdminUser", $email, time() + 3600, "/");
            header('Location: admin_page.php');
        } else {
            setcookie("loggedInUser", $email, time() + 3600, "/");
            header('Location: welcome.php'); 
        }
        exit();
    } else {
        $error = "Invalid email or password.";
        include 'index.php';
    }
} else {
    header('Location: index.php');
}

?>
