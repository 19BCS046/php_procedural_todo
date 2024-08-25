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
  session_start();

  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $success=false;
    $log=0;
    if(empty($username)){
      $er_username = "Please enter your username";
    }
    elseif (strlen($username) < 8) {
      $er_username = "Username must be at least 8 characters long";
    }
    if(empty($password)){
      $er_password = "Please enter your strong password";
    }  
    elseif (strlen($password) < 8) {
      $er_password = "Password must be at least 8 characters long";
    } 
    elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
      $er_password = "Password must include at least one lowercase letter, one uppercase letter, one digit, one special character, and be at least 8 characters long";
  }

  else{
    $success=true;
  }
  // echo$username;
  // echo$password;
  if ($success) {
    require_once "database.php";
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
                  $_SESSION['name'] = $row['username'];
                  $_SESSION['fullname'] = $row['fullname'];
                  $_SESSION['email'] = $row['email'];
                  $_SESSION['password'] = $row['todopassword'];
              }
          } else {
            //  echo "No results found.";
          }
          
        } else {
            echo "Error executing statement: " . mysqli_error($conn);
        }
        if (password_verify($password, $pass)) {
          $log=1;
      }
      if($username==$name && $log==1){
        header("Location: home.php");
        exit;
      }
        // Close the statement
        mysqli_stmt_close($stmt);
    } 
    else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

    } 
    // else {
    //     $er = "Error occurred while preparing the query";
    //     echo "<div class='error'>$er</div>";
    // }

  ?>

<div class="form-container">
  <h2>Login</h2>
  <?php if(!empty($er)) { echo "<div class='success'>$er</div>"; } ?>

  <form id="loginForm" action="index.php" method="post">
  <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
    <input class="i1" type="text" name="username" placeholder="Username">
    <?php if(!empty($er_username)) { echo "<div class='error'>$er_username</div>"; } ?>
    <span><img class="as" src="https://media.istockphoto.com/id/1314841909/vector/asterisk-icon-asterisk-sign-flat-icon-of-asterisk-isolated-on-white-background-vector.jpg?s=612x612&w=0&k=20&c=Bki3kVWMOdKHJwX2ITR5-75QBcIthJSu8rgoOcynuYo=" alt="field"></span>
    <input class="i1" type="password" name="password" placeholder="Password">
    <?php if(!empty($er_password)) { echo "<div class='error'>$er_password</div>"; } ?>
    <a class="forgot" href="forgot.php">Forgot Password? </a>
    <input class="i1" type="submit" value="Login" name="login">
    <div class="error-message" id="errorMessage"></div>
  </form>
  <div class="signup-link">
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
  </div>
</div>
</body>
</html>
