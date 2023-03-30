<?php
  session_start();
  include('../api/users.php');
  use api\users;
  
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (users::login($username, $password) == false) {
        header("Location: ../login.php?error=1");
        exit();
    } else {
        $_SESSION['user'] = $username;
        $_SESSION['pass'] = $password;
        header("Location: ../index.php");
        exit();
    }
