
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/signup.css">
  <title>todo</title>
</head>
<body>
<div class="form-container">
  
  <h2>Sign Up</h2>

  <?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  // Initialize error variables
  $er_fullname = $er_username = $er_email = $er_password = $er_con_password = "";

  // PHP validation and form submission logic
  if(isset($_POST['submit'])){
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $con_password = $_POST['con_password'];
   
    $us=false;
    $success = false; // Initialize success flag

    // Validation checks//vaymkmnqwgcdhxvq
    if(empty($fullname)){
        $er_fullname = "Please enter your full name";
    }
    if(empty($username)){
        $er_username = "Please enter your username(above 8 characters)";
    }
    elseif (strlen($username) < 8) {
        $er_username = "Username must be at least 8 characters long";
        // require_once "database.php"; // Include your database connection file
        // $sql = "SELECT * FROM todousers WHERE username = ?";
        // $stmt = mysqli_prepare($conn, $sql);
        // mysqli_stmt_bind_param($stmt, "s", $username);
        // mysqli_stmt_execute($stmt);
        // $result = mysqli_stmt_get_result($stmt);

        // if(mysqli_num_rows($result) > 0) {
        //     $er_username = "Username already exists";
        // }
    }
    
    if(empty($email)){
        $er_email = "Please enter your email";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $er_email = "Invalid email format";
    }
    if(empty($password)){
        $er_password = "Please enter your password";
    }
    elseif (strlen($password) < 8) {
        $er_password = "Password must be at least 8 characters long";
    } 
    elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        $er_password = "Password must include at least one lowercase letter, one uppercase letter, one digit, one special character, and be at least 8 characters long";
    }
    if(empty($con_password)){
        $er_con_password = "Please confirm your password";
    }
    elseif ($password !== $con_password){
        $er_con_password = "Passwords do not match";
    }
    // If all fields are non-empty, set success flag to true
    else {
        $success = true;
    }
    
    // If all validations pass, proceed with form submission
    if ($success) {
        //Include your database connection file
        require_once "database.php";
    
        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if(isset($_POST['submit'])){
            require_once "database.php";
        
            // Check if username already exists
            $sql = "SELECT * FROM todousers WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            // Check if a row was returned
            if(mysqli_num_rows($result) > 0) {
                $er_username = "Username already exists";
            } else {
                $us=true;
            }
        }
   if($us){

    
        // SQL statement
        $sql = "INSERT INTO todousers (fullname, username, email, todopassword) VALUES (?, ?, ?, ?)";
    
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
        // Prepare the SQL statement
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "ssss", $fullname, $username, $email, $passwordHash);
    
            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $er = "success";
               // echo "<div class='success'>$er</div>";
            } else {
                $er = "Error: " . mysqli_error($conn);
                echo "<div class='error'>$er</div>";
            }

// Include the PHPMailer autoload file
//require './phpmailer/PHPMailerAutoload.php';


//Load Composer's autoloader
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
    $mail->Body    = 'Name : '.$username.'<br>'.'Password :'.$password;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
  //  echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    
            // Close the statement
            mysqli_stmt_close($stmt);
        } 
    }
        else {
           // $er = "Error occurred while preparing the query";
          //  echo "<div class='error'>$er</div>";
            }
    }


    // echo"$fullname"."<br>";
    // echo"$username"."<br>";
    // echo"$email"."<br>";
    // echo"$password"."<br>";
    // echo"$con_password"."<br>";
    }
  ?>

  <?php if(!empty($er)) { echo "<div class='success'>$er</div>"; } ?>

  <form id="signupForm" action="signup.php" method="POST">
  <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
   
    <input class="i1" type="text" name="fullname" placeholder="Full Name">
    <?php if(!empty($er_fullname)) { echo "<div class='error'>$er_fullname</div>"; } ?>
    <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
 
    <input class="i1" type="text" name="username" placeholder="Username">
    <?php if(!empty($er_username)) { echo "<div class='error'>$er_username</div>"; } ?>
    <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
    
    <input class="i1" type="text" name="email" placeholder="Email">
    <?php if(!empty($er_email)) { echo "<div class='error'>$er_email</div>"; } ?>
    <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
    
    <input class="i1" type="password" name="password" placeholder="Password">
    <?php if(!empty($er_password)) { echo "<div class='error'>$er_password</div>"; } ?>
    <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
   
    <input class="i1" type="password" name="con_password" placeholder="Confirm password">
    <?php if(!empty($er_con_password)) { echo "<div class='error'>$er_con_password</div>"; } ?>
    <input class="i1" type="submit" value="Sign Up" name="submit">
  </form>

  <div class="signup-link">
    <p>Already have an account? <a class="l1" href="index.php">Login</a></p>
  </div>
</div>
</body>
</html>
