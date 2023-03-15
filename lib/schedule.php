<?php
    $origin = $_POST['origin'];
    $destiny = $_POST['destiny'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    header("Location: ../schedule.php?origin=$origin&destiny=$destiny&date=$date&time=$time");