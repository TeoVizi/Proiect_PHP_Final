<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="addMovies.css">
    <title>Add Movies</title>
    <style>
     
    </style>
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
    <h2>Add a New Movie</h2>
    <form action="process_add_movie.php" method="POST">
        <div class="form-group">
            <label for="titlu">Titlu:</label>
            <input type="text" id="titlu" name="titlu" required>
        </div>
        <div class="form-group">
            <label for="durata">Durata(In Minute):</label>
            <input type="number" id="durata" name="durata" required>
        </div>
        <div class="form-group">
            <label for="thumbnail_url">Thumbnail URL:</label>
            <input type="url" id="thumbnail_url" name="thumbnail_url" required>
        </div>
        <div class="form-group">
            <label for="stream_url">Stream URL:</label>
            <input type="url" id="stream_url" name="stream_url" required>
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
        <input type="submit" value="Add Movie" class="submit-btn">
    </form>
</div>

</body>
</html>
