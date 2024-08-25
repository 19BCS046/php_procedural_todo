<?php
$hostName = "127.0.0.1";
$dbUser = "your_username"; // Replace with your MySQL username
$dbPassword = "your_password"; // Replace with your MySQL password
$dbName = "todo_pro";
$conn = null;
        
try {
    // Attempt to establish the database connection
    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
    
    // Check if the connection was successful
    if (!$conn) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>";
    } else {
        // echo "Connected successfully to MySQL." . "<br>";
    }
} catch (Exception $e) {
    echo "Could not connect: " . $e->getMessage() . "<br>";
}
?>
