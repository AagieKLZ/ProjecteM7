<?php

    session_start();
    include('../api/users.php');
    use api\users;
    $name = $_POST['name'];
    $username = $_POST['email'];
    $password = $_POST['password'];
    $rpassword = $_POST['rpassword'];
    if ($password != $rpassword){
        header("Location: ../users/new.php?error=1");
        exit();
    } else {
        if (users::create($name, $username, $password) == false) {
            header("Location: ../users/new.php?error=2");
            exit();
        } else {
            header("Location: ../users.php?success=true");
            exit();
        }
    }