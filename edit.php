<!DOCTYPE html>
<html lang="en">
<head>
  <title>todo-list</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/signup.css">  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <p class="web">Todo List</p>
    </div>
    <ul class="nav navbar-nav">
        <ul class="dropdown-menu">

        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <li class="nav-item active">
        <a class="nav-link" href="home.php">Daily Task <span class="sr-only">(current)</span></a>
      </li>
      <li class="l1"><a href="edit.php"><span class="glyphicon glyphicon-user"></span>Edit Profile</a></li>
      <li class="l1"><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      
    </ul>
  </div>
</nav><div class="edit">
  
<div class="form-container" class="container" >
<h2>Edit Profile</h2>

<?php
  session_start();
  // Check if SESSION variables are set
  $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
  $username = isset($_SESSION['name']) ? $_SESSION['name'] : '';
  $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
  // Database connection parameters
  require_once "database.php";
  // Check if the form was submitted
  if(isset($_POST['update'])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Prepare and execute the SQL statement
    $sql = "UPDATE todousers SET fullname=?, email=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullname, $email, $username);
    if ($stmt->execute()) {
        $er = "success"; // Set a success message
    } else {
        echo "Error updating record: " . $conn->error; // Echo the error if the execution fails
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

  ?>
  <?php if(!empty($er)) { echo "<div class='success'>$er</div>"; } ?>

<form id="signupForm" action="edit.php" method="POST">
  <input class="i1" type="text" name="fullname" placeholder="Full Name" value="<?php echo $fullname; ?>">
  <input class="i1" type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
  <input class="i1" type="text" name="email" placeholder="Email" value="<?php echo $email; ?>">
  <input class="i1" type="submit" value="Update" name="update">
</form>    
</div>
</div>
</body>
</html>
