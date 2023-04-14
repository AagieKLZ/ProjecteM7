<?php
    include("../api/users.php");
    use api\users;
    $id = $_POST["id"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    if (users::update($id, $name, $email)){
        header("Location: ../users.php?success=true&action=edit");
    } else {
        header("Location: ../users.php?error=1");
    }
