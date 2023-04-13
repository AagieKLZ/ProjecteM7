<?php
    include("../api/users.php");
    use api\users;
    $id = $_POST["id"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    users::update($id, $name, $email);
    header("Location: ../users.php");