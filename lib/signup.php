<?php

    session_start();
    include('../api/users.php');
    use api\users;
    $name = $_POST['name'];
    $username = $_POST['email'];
    $password = $_POST['password'];
    $rpassword = $_POST['rpassword'];
    if ($password != $rpassword){
        header("Location: ../users/new.php?error=wrong-password");
        exit();
    } else {
        if (!users::create($name, $username, $password)) {
            header("Location: ../users/new.php?error=503");
            exit();
        } else {
            header("Location: ../users.php?success=true");
            exit();
        }
    }