

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="contact.css">
    <title>Contact Form</title>
    <head>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
</head>
</head>
<body>



<div class="container">
    <h2>Contact Us</h2>
    <form action="phpmailer/mail_cod.php" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
       

        <div class="g-recaptcha" data-sitekey="6Lc0RVMpAAAAAP3dLPVsSqmRcyR_dTRKmWU3IOPZ"></div>
        <input type="submit" value="Submit" class="submit-btn">
          
    </form>
</div>

</body>
</html>

