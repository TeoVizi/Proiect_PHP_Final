<?php



function connectToDatabase() {
    $conn = mysqli_connect("localhost", "root", "1212", "proiect");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

function authenticateUser($email, $password) {
    $conn = connectToDatabase();

    $email = $conn->real_escape_string($email);
    
    $sql = "SELECT parola, tip FROM utilizatori WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['parola'])) {
            $conn->close();
            return array('success' => true, 'role' => $row['tip']);
        }
    }
    
    $conn->close();
    return array('success' => false, 'role' => null);
} 

?>
