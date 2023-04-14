<?php 
    include '../api/users.php';
    use api\users;
    if (!isset($_POST['id'])) {
        header('Location: ../users.php?error=1');
    } else {
        if (users::delete($_POST['id'])){
            header('Location: ../users.php?success=true&action=delete');
        } else {
            header('Location: ../users.php?error=1');
        };
    }