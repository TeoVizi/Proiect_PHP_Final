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

// Function to get movie ID by title using $conn->query
function getMovieIdByTitle($conn, $movieTitle) {
    // Escape the movie title to prevent SQL injection
    $escapedTitle = $conn->real_escape_string($movieTitle);
    
    // Construct the SQL query
    $sql = "SELECT film_id FROM filme WHERE titlu = '$escapedTitle'";
    
    // Execute the query
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        // Fetch the first row
        $row = $result->fetch_assoc();
        
        // Get the movie ID
        $movieId = $row['film_id'];
        
        // Free the result set
        $result->free_result();
        
        return $movieId;
    } else {
        return null; // Return null if movie title not found or on query execution error
    }
}


function insertIntoUtilizatoriFilme($conn, $userId, $filmId) {
    // Construct the SQL query
    $sql = "INSERT INTO utilizatori_filme (user_id, film_id) VALUES ($userId, $filmId)";
    
    // Execute the query
    $result = $conn->query($sql);
    
    if ($result) {
        // Return true if the insertion was successful
        return true;
    } else {
        // Return false if there was an error in the query execution
        return false;
    }
}




// Retrieve movie title, payment amount, and user email from the form
$movieTitle = $_POST['movie_title'];
$paymentAmount = $_POST['payment_amount'];

$userEmail = '';
if (!empty($_COOKIE['loggedInAdminUser'])) {
    $userEmail = $_COOKIE['loggedInAdminUser'];
} elseif (!empty($_COOKIE['loggedInUser'])) {
    $userEmail = $_COOKIE['loggedInUser'];
}
// Assuming you have a database connection function and the necessary SQL query here
$conn = connectToDatabase();

// Step 1: Retrieve user_id based on email
$userId = getUserIdByEmail($conn, $userEmail);
$movieId = getMovieIdByTitle($conn, $movieTitle);

$confirmationLink = "confirmation.php?movie_title=" . urlencode($movieTitle) . "&payment_amount=" . urlencode($paymentAmount) . "&user_id=" . urlencode($userId) . "&film_id=" . urlencode($movieId);


if ($userId !== null) {
    // Step 2: Check if the user has already purchased the movie
    $stmt = $conn->prepare("SELECT * FROM plati WHERE user_id = ? AND titlu = ?");
    $stmt->bind_param("is", $userId, $movieTitle);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {

       insertIntoUtilizatoriFilme($conn, $userId, $movieId);

        // Step 3: Insert a new record into the 'plati' table
        $currentDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO plati (user_id, titlu, suma, data) VALUES ('$userId', '$movieTitle', '$paymentAmount', '$currentDate')";

        if ($conn->query($sql) === true) {
            // Payment successful
            header("Location: $confirmationLink");
            exit;
        } else {
            // Payment failed, handle the error
            echo "Payment failed. Please try again.";
        }
        
    } else {
        // User has already purchased the movie
        echo "You have already purchased this movie.";
    }
} else {
    // User not found, handle the error
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>
