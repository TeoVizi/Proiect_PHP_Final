<?php
if (!isset($_COOKIE["loggedInAdminUser"])) {
    header('Location: index.php'); 
    exit();
}
?>
<?php
include 'auth_functions.php';
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movieName = trim($_POST['movieName']);

    $conn = connectToDatabase();

    $checkSql = "SELECT * FROM filme WHERE titlu = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $movieName);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        $deleteSql = "DELETE FROM filme WHERE titlu = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("s", $movieName);
        
        if ($deleteStmt->execute()) {
            $_SESSION['message'] = "Movie successfully removed.";
        } else {
            $_SESSION['error'] = "Error removing movie.";
        }
        
        $deleteStmt->close();
    } else {
        $_SESSION['error'] = "Movie not found in the database.";
    }

    $checkStmt->close();
    include 'removeMovies.php';
    exit();
} else {
    header('Location: removeMovies.php');
}


$conn->close();
?>
