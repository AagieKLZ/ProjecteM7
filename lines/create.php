<?php

    include '../api/lines.php';
    use api\lines;
    if (isset($_POST["lane"]) && isset($_POST["color"])){
        $name = "R".$_POST["lane"];
        if (lines::createNew($name, $_POST["color"])){
            header("Location: ./view.php?success=true&action=create");
        } else {
            header("Location: ./view.php?success=false&action=create");
        }
    }