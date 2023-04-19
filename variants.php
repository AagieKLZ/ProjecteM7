<?php
session_start();
session_get_cookie_params();
include './api/lines.php';
include "./api/route.php";

use api\lines;

error_reporting(0);
if (isset($_GET["lane"])) {
    $defaultLane = $_GET["lane"];
} else {
    $defaultLane = "R1";
}
$directions = lines::getDirections($defaultLane);

if (isset($_GET["direction"])) {
    $defaultDirection = $_GET["direction"];
} else {
    $defaultDirection = 0;
}

$defaultValue = $directions[$defaultDirection];
if (isset($_GET["origin"])) {
    $defaultOrigin = $_GET["origin"];
} else {
    $defaultOrigin = $defaultValue["Origin"];
}

if (isset($_GET["destiny"])) {
    $defaultDestiny = $_GET["destiny"];
} else {
    $defaultDestiny = $defaultValue["Destiny"];
}

$stations = lines::getAllStationsBetween($defaultOrigin, $defaultDestiny);
$color = lines::getLineColour($defaultLane);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenfe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">


</head>

<body class="mt-5">

    <?php include 'components/navbar.php'; ?>
    <main class="flex flex-col justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[5rem]">
        <div class="fixed top-0 left-0 h-screen w-1/2 flex flex-col justify-center items-center">
            <div class="flex justify-center mt-4">
                <div class="font-semibold text-3xl text-center px-5 py-4 <?= $color ?> <?= $color == "bg-yellow-500" ? "text-black" : "text-white" ?>"><?= $defaultLane ?></div>
            </div>
            <div class="flex flex-col ml-8 mt-2">
                <div class="text-2xl font-semibold text-center"><?= $defaultOrigin ?> - <?= $defaultDestiny ?></div>
            </div>
        </div>
        <div class="absolute top-0 left-[50%] w-1/2 h-fit my-24 border-l-4 border-l-<?= substr($color, 3, strlen($color)) ?> p-8 flex flex-col items-start space-y-7">
            <?php
            foreach ($stations as $i => $station) :
            ?>
                <div>
                    <?= $station["name"] ?>
                    <div class="relative right-[2.6rem] bottom-5 rounded-full h-4 w-4 <?= $color ?>"></div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="./routes.php?lane=<?= $defaultLane ?>" class="block fixed top-24 left-12 text-white font-semibold rounded-lg flex justify-center items-center bg-fuchsia-900 px-5 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>