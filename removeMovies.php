<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="removeMovies.css">
    <title>Remove Movie</title>
 
</head>

<?php
if (!isset($_COOKIE["loggedInAdminUser"])) {
    header('Location: index.php'); 
    exit();
}
?>


<body>

<div class="form-container">
<a href="admin_page.php"><-</a>
    <h2>Remove a Movie</h2>
   
    <form action="process_remove_movie.php" method="POST">
        <div class="form-group">
            <label for="movieName">Movie Name:</label>
            <input type="text" id="movieName" name="movieName" required>
        </div>
        <?php
            if (isset($_SESSION['error'])) {
                echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            } elseif (isset($_SESSION['message'])) {
                echo "<p style='color:green;'>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }
            ?>
        <input type="submit" value="Remove Movie" class="submit-btn">
    </form>
</div>

</body>
</html>
