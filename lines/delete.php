<?php
    include("../api/lines.php");
    use api\lines;

    if (isset($_GET["name"])){
        if (lines::deleteLine($_GET["name"])){
            header("Location: ./view.php?success=true&action=delete");
        } else {
            header("Location: ./view.php?success=false&action=delete");
        }
    } else {
        header("Location: ./view.php?success=false&action=delete");
    }