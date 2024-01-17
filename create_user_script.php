<?php
include 'auth_functions.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = trim(strip_tags($_POST['first_name'])); 
    $lastName = trim(strip_tags($_POST['last_name'])); 
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT user_id FROM utilizatori WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Email already exists.";
            } else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $insertStmt = $conn->prepare("INSERT INTO utilizatori (email, parola, nume, prenume) VALUES (?, ?, ?, ?)");
                if ($insertStmt) {
                    $insertStmt->bind_param("ssss", $email, $hashedPassword, $firstName, $lastName);
                    if ($insertStmt->execute()) {
                        setcookie("loggedInUser", $email, time() + 86400, "/");
                        header("Location: welcome.php");
                        exit();
                    } else {
                        $error = "Error creating user: " . $insertStmt->error;
                    }
                    $insertStmt->close();
                } else {
                    $error = "Error preparing statement: " . $conn->error;
                }
            }
            $stmt->close();
        } else {
            $error = "Error preparing statement: " . $conn->error;
        }
    }
} else {
    header('Location: create_user.php');
}


if (!empty($error)) {
    include 'create_user.php'; 
}
?>

