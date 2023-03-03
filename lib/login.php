<?php
  session_start();
  
  if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
        
    // Set the session variables and redirect to index.php
    $_SESSION['user'] = $username;
    $_SESSION['pass'] = $password;
    header("Location: index.php");
    exit();
  }
?>
