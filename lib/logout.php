<?php
    session_get_cookie_params();
    session_start();
    session_unset();
    header("Location: ../index.php");
