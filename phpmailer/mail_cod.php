
<?php


function getUserIdByEmail($conn, $email) {
  $stmt = $conn->prepare("SELECT user_id FROM utilizatori WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
      return $row['user_id'];
  }
  $stmt->close();
  return null;
}

function insertIntoContact($conn, $userId, $description) {

  $datetime = date("Y-m-d H:i:s"); // Formatul DATETIME pentru MySQL
  $query="insert into contact(user_id,descriere,data) values ('".$userId."','".$description."','".$datetime."');";
  $conn->query($query);
 
}

if(empty($_POST['g-recaptcha-response'])) {
  die('Please go back and checj the reCAPTCHA box.');
}



  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
      // Google reCAPTCHA API secret key 
      $secret_key = '6Lc0RVMpAAAAAM7-t9o0et-ON2O3fZ1q9PGW-wcM';
       
      // reCAPTCHA response verification
      $verify_captcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']); 
      
      // Decode reCAPTCHA response 
      $verify_response = json_decode($verify_captcha); 
       
      // Check if reCAPTCHA response returns success 
      if($verify_response->success){ 

require_once('class.phpmailer.php');
require_once('mail_config.php');
require_once('../auth_functions.php');


// Retrieve user email from cookie
$userEmail = '';
if (!empty($_COOKIE['loggedInAdminUser'])) {
    $userEmail = $_COOKIE['loggedInAdminUser'];
} elseif (!empty($_COOKIE['loggedInUser'])) {
    $userEmail = $_COOKIE['loggedInUser'];
}


$description = $_POST['description'];
$name = $_POST['name'];
$surname = $_POST['surname'];

// Check if email is retrieved successfully
if (empty($userEmail)) {
    exit("Email not found in cookies.");
}

$conn = connectToDatabase();
$userId = getUserIdByEmail($conn, $userEmail); // Funcție ipotetică pentru a obține user_id
if ($userId !== null) {
  echo $userId;
  insertIntoContact($conn, $userId, $description);
}

$conn->close();

$message = "Thank you for contacting us $name $surname! Here is your message: $description";
$message = wordwrap($message, 160, "<br />\n");

$mail = new PHPMailer(true); 

$mail->IsSMTP();

try {
    $mail->SMTPDebug  = 0;                     
    $mail->SMTPAuth   = true; 
    $mail->SMTPSecure = "ssl";                 
    $mail->Host       = "smtp.gmail.com";      
    $mail->Port       = 465;                   
    $mail->Username   = $username;  // SMTP username for daw.php1@mail.com
    $mail->Password   = $password;  // SMTP password

    $mail->SetFrom('daw.php1@mail.com', 'Daw Project');
    $mail->AddReplyTo('daw.php1@mail.com', 'Daw Project');
    $mail->AddAddress($userEmail);

    $mail->Subject = 'Confirmarea mesajului tau';
    $mail->AltBody = 'Pentru a vizualiza acest mesaj este necesar un vizualizator HTML compatibil!'; 
    $mail->MsgHTML($message);
    $mail->Send();
    echo "Mesajul a fost trimis cu succes</p>\n";
} catch (phpmailerException $e) {
    echo $e->errorMessage(); // Error from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage(); // Error from anything else!
}
}
}







?>