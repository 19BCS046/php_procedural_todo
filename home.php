<?php
require_once "database.php";
session_start(); 
$errors = "";
$name = isset($_SESSION['name']) ? $_SESSION['name'] : ''; // Define $name here

if(isset($_POST['submit'])){
  $task = $_POST['task'];

  if(empty($task)){
    $errors = "You must fill in the task";
  }
  else {
    mysqli_query($conn,"INSERT INTO tasks (task, username) VALUES ('$task','$name')");
    header('location: home.php');
    exit(); // Add exit after redirect to prevent further execution
  }
}
if(isset($_GET['del_task'])){
  $id = $_GET['del_task'];
  mysqli_query($conn,"DELETE FROM tasks WHERE id=$id");
  header('location: home.php');
  exit(); // Add exit after redirect to prevent further execution
}
$task = mysqli_query($conn,"SELECT * FROM tasks WHERE username='$name'");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>todo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/home.css">
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
</nav>
  
<div class="container">
<div class="todo-container">
  <h2>Todo List</h2>
  <form action="home.php" method="POST">
    <?php if(isset($errors)) {?>
      <p><?php echo $errors; ?></p>
      <?php } ?>
    <input type="text" name="task"  class="task_input" placeholder="Enter a task">
    <button type="submit" class="add_btn" name="submit" >Add Task</button>
  </form>
  <table class="t1">
    <thead>
      <tr>
        <th>S.No</th>
        <th class="task">Task</th>
        <th class="delete">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; while($row=mysqli_fetch_array($task)) {?>
      <tr>
        <td><?php  echo $i ?></td>
        <td class="task"><?php echo $row['task']; ?></td>
        <td class="delete">
          <a href="home.php?del_task=<?php echo $row['id'];?>">x</a></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>
</div>

</body>
</html>
