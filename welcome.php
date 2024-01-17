<?php
// Conectare la baza de date
include 'auth_functions.php';
$conn = connectToDatabase();

if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

$sql = "SELECT titlu, durata, thumbnail_url, stream_url FROM filme";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    
</head>

<?php
if (!isset($_COOKIE["loggedInUser"]) && !isset($_COOKIE["loggedInAdminUser"])) {
    header('Location: index.php'); 
    exit();
}
?>

<body>
    <div class="header">
        <a href="welcome.php">All Movies</a>
        <a href="yourMovies.php">Your Movies</a>
        <a href="contact.php">Contact</a>

        <form action="logout.php" method="POST">
            <input type="submit" name="logout" value="Logout" class="logout-btn">
        </form>

    </div>
    
    <div class="film-row">
        <?php
        // Presupunând că $result este rezultatul unei interogări la baza de date
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='film-box'>";
                echo "<div class='film-info'>";
                echo "<div class='top-left'>" . htmlspecialchars($row["durata"]) . " min</div>";
                echo "<div class='bottom-left'>";
                echo "<span class='film-title'>" . htmlspecialchars($row["titlu"]) . "</span><br>";
                echo "</div>";
                echo "<div class='bottom-right'>";
                echo "<a class='plus-button' href='payment.php?movie_title=" . urlencode($row["titlu"]) . "'>+</a>";
                echo "</div>";
                echo "</div>"; 
                echo "</div>";
            }
        } else {
            echo "0 filme găsite";
        }
        ?>
    </div>

</body>

</html>
