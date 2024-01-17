<!DOCTYPE html>
<html>
<head>
    <title>Create User Page</title>
    <link rel="stylesheet" type="text/css" href="create_user.css">
</head>

<style>

</style>

<body>
    <div class="user-container">
        <h2>Create your account:</h2>
        <form action="create_user_script.php" method="POST">
            <div class="form-group">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first_name" value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last_name" value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm_password" value="" required>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>


            <div class="button-container">
                <input type="submit" value="Create Account">
            </div>

        </form>
    </div>
</body>
</html>
