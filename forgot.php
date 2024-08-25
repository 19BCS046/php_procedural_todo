<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/login.css">
    <title>todo</title>
</head>
<body>
    <?php
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\SMTP;
      use PHPMailer\PHPMailer\Exception;
 require_once "database.php";
 session_start();
 $success=false;
 if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    if(empty($username)){
      $er_username = "Please enter your username";
    }
    elseif (strlen($username) < 8) {
      $er_username = "Username must be at least 8 characters long";
    }
    if(empty($email)){
      $er_password = "Please enter your email";
    }  
//     elseif (strlen($password) < 8) {
//       $er_password = "Password must be at least 8 characters long";
//     } 
//     elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
//       $er_password = "Password must include at least one lowercase letter, one uppercase letter, one digit, one special character, and be at least 8 characters long";
//   }

  else{
    $success=true;
  }
}
 if($success){
 $sql = "SELECT * FROM todousers WHERE username = ?";
 // Prepare the statement
 $stmt = mysqli_prepare($conn, $sql);
 if ($stmt) {
     // Bind the parameters
     mysqli_stmt_bind_param($stmt, "s", $username);
     // Execute the statement
     if (mysqli_stmt_execute($stmt)) {
         // Get the result
         $result = mysqli_stmt_get_result($stmt);
         // Check if there are any rows returned
         if (mysqli_num_rows($result) > 0) {
           // Output each row
           while ($row = mysqli_fetch_assoc($result)) {
               $name= $row["username"];
               $pass= $row["todopassword"];
               $email=$row["email"];
            //    $_SESSION['name'] = $row['username'];
            //    $_SESSION['fullname'] = $row['fullname'];
            //    $_SESSION['email'] = $row['email'];
            //    $_SESSION['password'] = $row['todopassword'];
           }
           require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'perumalshanmugam2002@gmail.com';                     //SMTP username
    $mail->Password   = 'vaymkmnqwgcdhxvq';                               //SMTP password
   // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('perumalshanmugam2002@gmail.com', 'Perumal');
    $mail->addAddress($email,$username);     //Add a recipient
  //  $mail->addAddress('ellen@example.com');               //Name is optional
  //  $mail->addReplyTo('info@example.com', 'Information');
  //  $mail->addCC('cc@example.com');
  //  $mail->addBCC('bcc@example.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Your Name and Password';
    $mail->Body    = 'Name : '.$username.'<br>'.'Password :'.$pass;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $er = "successfully sent to your email";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
       } else {
          echo "No results found.";
       }
    }
}
}
    ?>
    <div class="form-container">
  <h2>Password Recover</h2>
  <?php if(!empty($er)) { echo "<div class='success'>$er</div>"; } ?>

  <form id="loginForm" action="forgot.php" method="post">
  <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
    <input class="i1" type="text" name="username" placeholder="Username">
    <?php if(!empty($er_username)) { echo "<div class='error'>$er_username</div>"; } ?>
    <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
    <input class="i1" type="text" name="email" placeholder="email">
    <?php if(!empty($er_password)) { echo "<div class='error'>$er_password</div>"; } ?>
    <input class="i1" type="submit" value="submit" name="submit">
    <div class="error-message" id="errorMessage"></div>
  </form>
  <div class="signup-link">
    <p>Back to signup? <a href="signup.php">Sign up</a></p>
    <p>Back to login? <a href="index.php">Login up</a></p>
  </div>
</div>
</body>
</html>