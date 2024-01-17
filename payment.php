<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .payment-box {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            font-size: 24px;
        }

        p {
            font-size: 18px;
        }

        .confirm-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .confirm-button:hover {
            background-color: #0056b3;
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
<div class="payment-box">
        <?php
        // Retrieve the movie title from the URL
        $movieTitle = isset($_GET['movie_title']) ? urldecode($_GET['movie_title']) : '';
        $paymentAmount = 20; // Assuming a fixed payment amount

        if (!empty($movieTitle)) {
            echo "<h2>Payment for $movieTitle</h2>";
            echo "<p>Amount: $paymentAmount lei</p>";
            echo "<form method='post' action='process_payment.php'>";
            echo "<input type='hidden' name='movie_title' value='$movieTitle'>";
            echo "<input type='hidden' name='payment_amount' value='$paymentAmount'>";
            echo "<button type='submit' name='confirm_payment' class='confirm-button'>Confirm Payment</button>";
            echo "</form>";
        } else {
            echo "<p>Invalid movie title.</p>";
        }
        ?>
    </div>

</body>
</html>
