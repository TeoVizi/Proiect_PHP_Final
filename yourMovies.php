<!DOCTYPE html>
<html>
<head>
<style>
    .movie-container {
            display: flex;
            flex-wrap: nowrap; /* Prevent wrapping to the next line */
            overflow-x: auto; /* Enable horizontal scrolling if needed */
        }
 /* CSS styles for movie boxes */
.movie-box {
    position: relative;
    margin-top: 30px;
    margin-left: 10px; /* Space between boxes */
    border: 1px solid black;
    width: 10rem;
    height: 10rem;

    background-color: #000;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    overflow: hidden;
    transition: transform 0.2s ease-in-out;
}

.movie-box:hover {
    transform: scale(1.05);
}

.movie-title {
    font-weight: bold;
    padding: 5px;
    background-color: rgba(0, 0, 0, 0.7);
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
}

.movie-duration {
    font-size: 12px;
    padding: 5px;
    background-color: rgba(0, 0, 0, 0.7);
    position: absolute;
    top: 0;
    left: 0;
}

.plus-button {
    position: absolute;
    bottom: 0;
    right: 0;
    background-color: #e50914;
    color: #fff;
    border: none;
    padding: 5px;
    cursor: pointer;
}

    </style>
</head>
<body>

<?php
if (!isset($_COOKIE["loggedInUser"]) && !isset($_COOKIE["loggedInAdminUser"])) {
    header('Location: index.php'); 
    exit();
}
?>

<?php
include 'auth_functions.php';


function getUserIdByEmail($conn, $email) {
    $sql = "SELECT user_id FROM utilizatori WHERE email = '" . $conn->real_escape_string($email) . "'";
    $result = $conn->query($sql);

    if ($result === false) {
        // Handle the SQL query error
        return null;
    }

    if ($result->num_rows > 0) {
        // User found, fetch the user_id
        $row = $result->fetch_assoc();
        $userId = $row['user_id'];
        $result->free(); // Free the result set
        return $userId;
    }

    // User not found or an error occurred
    return null;
}

// Assuming you have a way to identify the logged-in user and get their email
$userEmail = '';
if (!empty($_COOKIE['loggedInAdminUser'])) {
    $userEmail = $_COOKIE['loggedInAdminUser'];
} elseif (!empty($_COOKIE['loggedInUser'])) {
    $userEmail = $_COOKIE['loggedInUser'];
}
$conn = connectToDatabase();
// Get the user's ID based on their email
$userId = getUserIdByEmail($conn, $userEmail);

if ($userId !== null) {
    // Query the utilizatori_filme table to get film IDs for the logged-in user
    $filmIds = array();
    $sql = "SELECT film_id FROM utilizatori_filme WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $filmIds[] = $row['film_id'];
        }
       
    }

    // Query the filme table to get movie information for purchased movies
    $movies = array();
    foreach ($filmIds as $filmId) {
        $sql = "SELECT * FROM filme WHERE film_id = $filmId";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $movies[] = $row;
            }
        }
    }

 
    echo '<a href="javascript:history.go(-1)" style="text-decoration: none; background-color: #333; color: white; padding: 10px 20px; border-radius: 5px;"><</a>';
    
    
    // // Display the purchased movies
    echo "<div class='movie-container'>";
    foreach ($movies as $movie) {
      
        echo "<div class='movie-box'>";
        echo "<div class='movie-info'>";
        echo "<span class='movie-duration'>" . htmlspecialchars($movie['durata']) . " min</span>";
        echo "<h3 class='movie-title'>" . htmlspecialchars($movie['titlu']) . "</h3>";
        echo "</div>";
        echo "</div>";
        
    }
    echo "</div>";

} else {
    echo "User not found.";
}

// Close the database connection
$conn->close();
?>
</body>
</html>