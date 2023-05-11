<?php
    include("../api/lines.php");
    use api\lines;

    if (isset($_POST["name"]) && isset($_POST["color"])){
        if (lines::updateColor($_POST["name"], $_POST["color"])){
            header("Location: ../view.php?success=true&action=update");
        } else {
            header("Location: ../view.php?success=false&action=update");
        }
    } else {
        header("Location: ../view.php?success=false&action=update");
    }