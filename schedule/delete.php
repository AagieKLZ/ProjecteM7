<?php
    include("../api/route.php");
    use api\route;

    if (isset($_GET["train"])){
        if (route::deleteRoute($_GET["train"])){
            header("Location: ./view.php?success=true&action=delete");
        } else {
            header("Location: ./view.php?success=false&action=delete");
        }
    } else {
        header("Location: ./view.php?success=false&action=delete");
    }