<?php
session_start();
session_get_cookie_params();
include './api/lines.php';
include "./api/route.php";

use api\lines;

error_reporting(0);
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
    <?php if (isset($_GET["route"])) {
        $defaultLane = $_GET["route"];
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
    $directions = lines::getDirections($defaultLane);
    foreach ($directions as $index => $direction) {
        if ($direction["Origin"] == $defaultOrigin && $direction["Destiny"] == $defaultDestiny) {
            $defaultDirection = $index;
        }
    }
    if ($defaultDirection == 0) {
        $prev = null;
        $next = $directions[1];
    } else if ($defaultDirection == count($directions) - 1) {
        $prev = $directions[count($directions) - 2];
        $next = null;
    } else {
        $prev = $directions[$defaultDirection - 1];
        $next = $directions[$defaultDirection + 1];
    }
    ?>
    <main class="flex flex-col justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[5rem]">
        <div class="fixed top-0 left-0 h-screen w-1/2 flex flex-col justify-center items-center">
            <div class="flex justify-center w-full mt-4 ">
                <div class="font-semibold text-3xl text-center px-5 py-4 <?= $color ?> <?= $color == "bg-yellow-300" ? "text-black" : "text-white" ?>"><?= $defaultLane ?></div>
            </div>
            <div class="flex flex-col ml-8 mt-8 w-full">
                <div class="text-2xl font-semibold text-center"><?= $defaultOrigin ?> - <?= $defaultDestiny ?></div>
                <a href="./variants.php?lane=<?=$defaultLane ?>&origin=<?= $defaultDestiny?>&destiny=<?= $defaultOrigin?>" class="flex justify-center items-center px-5 py-2 border-2 border-fuchsia-900 hover:bg-fuchsia-900 hover:text-white stroke-fuchsia-900 hover:stroke-white font-semibold text-fuchsia-900 rounded-lg w-fit mx-auto mt-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 stroke-inherit mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                    </svg>

                    Cambiar Dirección
                </a>
                <div class="flex justify-between w-2/3 h-fit items-center mx-auto mt-8">
                    <?php if ($prev != null) : ?>
                        <a href="./variants.php?route=<?= $defaultLane ?>&origin=<?= $prev['Origin'] ?>&destiny=<?= $prev['Destiny'] ?>" class="w-1/2 h-full flex flex-col mr-4 border p-2 rounded-xl border-fuchsia-900">
                            <div class="flex text-fuchsia-900 font-semibold stroke-fuchsia-900 items-start justify-start">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                                </svg>
                                Anterior
                            </div>
                            <div class="font-fuchsia-900 font-light"><?= $prev["Origin"] ?> - <?= $prev["Destiny"] ?></div>
                        </a>
                    <?php else: ?>
                        <div class="w-1/2 mr-4"></div>
                    <?php endif; ?>
                    <?php if ($next != null) : ?>
                        <a href="./variants.php?route=<?= $defaultLane ?>&origin=<?= $next['Origin'] ?>&destiny=<?= $next['Destiny'] ?>" class="w-1/2 flex h-full flex-col border p-2 rounded-xl border-fuchsia-900">
                            <div class="flex text-fuchsia-900 font-semibold stroke-fuchsia-900 items-end justify-end">
                                Siguiente
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2 rotate-180">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                                </svg>

                            </div>
                            <div class="flex items-end justify-end font-fuchsia-900 font-light"> <?= $next["Origin"] ?> - <?= $next["Destiny"] ?></div>
                        </a>
                        <?php else: ?>
                        <div class="w-1/2 ml-4"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="absolute top-0 left-[50%] w-1/2 h-fit my-24 border-l-4 border-l-<?= substr($color, 3, strlen($color)) ?> p-8 flex flex-col items-start space-y-8">
            <?php
            foreach ($stations as $i => $station) :
            ?>
                <div>
                    <div class="station text-lg hover:font-semibold hover:text-<?= substr($color, 3, strlen($color)) ?>">
                        <?= $station["name"] ?>
                        <div class="flex justify-start space-x-4">
                            <?php foreach (lines::getConnectionsOfStation($station['id']) as $line) : ?>
                                <div class="py-1 px-2 font-semibold <?= $line["colour"] ?> <?= $line["colour"] == "bg-yellow-300" ? "text-black" : "text-white" ?>">
                                    <?= $line['route_id'] ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="relative line-circle right-[2.6rem] bottom-7 rounded-full h-4 w-4 <?= $color ?>"></div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="./routes.php?lane=<?= $defaultLane ?>" class="block fixed top-24 left-12 text-white font-semibold rounded-lg flex justify-center items-center bg-fuchsia-900 px-5 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>
    </main>
    <?php include ("./components/searchModal.php") ?>
</body>

</html>