<?php

include 'auth_functions.php';

session_start(); 

$conn = connectToDatabase();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titlu = $conn->real_escape_string(trim($_POST['titlu']));
    $durata = $conn->real_escape_string(trim($_POST['durata']));
    $thumbnail_url = $conn->real_escape_string(trim($_POST['thumbnail_url']));
    $stream_url = $conn->real_escape_string(trim($_POST['stream_url']));

    $checkSql = "SELECT * FROM filme WHERE titlu = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $titlu);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Movie already exists.";
    } else {
        $insertSql = "INSERT INTO filme (titlu, durata, thumbnail_url, stream_url) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("siss", $titlu, $durata, $thumbnail_url, $stream_url);

        if ($insertStmt->execute()) {
            $_SESSION['message'] = "Movie added successfully!";
        } else {
            $_SESSION['error'] = "Error adding movie: " . $conn->error;
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    include 'addMovies.php';
    exit();
} else {
    header('Location: addMovies.php');
}

$conn->close();
?>
