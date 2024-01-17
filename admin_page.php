<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="admin_page.css">

    <title>Admin Page</title>
   
</head>

<?php
if (!isset($_COOKIE["loggedInAdminUser"])) {
    header('Location: index.php'); 
    exit();
}
?>

<body>

<div class="admin-box">
    <h1>Hi there, admin!</h1>
    <a href="addMovies.php" class="admin-link">Add Movies</a>
    <a href="removeMovies.php" class="admin-link">Remove Movies</a>
    <form action="logout.php" method="POST">
            <input type="submit" name="logout" value="Logout" class="logout-btn">
    </form>

    <a href="welcome.php" class="homepage-link">Homepage</a>
    <a href="index.php" class="homepage-link">Authentification Page</a>

   

</div>


</body>
</html>
