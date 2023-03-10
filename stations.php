<?php
session_start();
session_get_cookie_params();
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
    <main class="flex flex-row justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[3.5rem]">
        <div class="flex flex-col items-center w-full space-y-8 w-2/3 pb-4">
            <div class="w-full text-center text-4xl font-bold h-52 flex justify-center items-center station-main text-white">
                Estaciones
            </div>
            <div class="flex flex-row justify-evenly items-center md:w-2/3 w-[90%] text-center text-xl font-semibold border-b border-b-black">
                <div class="w-1/2 text-left px-10 py-1">Estación</div>
                <div class="w-1/2 py-1">Correspondencias</div>
            </div>
            <?php
            include './api/trainRoutes.php';

            use api\trainRoutes;

            $stations = trainRoutes::getAllStationsWithConnections();

            foreach ($stations as $station) {
                echo '<div class="flex flex-row justify-evenly items-center md:w-2/3 w-[90%] text-center text-xl">
            <div class="w-1/2 text-left">';
                echo $station["name"];
                echo '</div>';
                echo '<div class="flex flex-row flex-wrap max-w-lg min-w-md justify-center font-semibold w-1/2">';
                foreach ($station["connections"] as $connection) {
                    echo '<div class="';
                    echo $connection["colour"] . ' text-white flex justify-center items-center py-2 px-2 mx-2">';
                    echo $connection["route_id"];
                    echo '</div>';
                }
                echo '</div></div>';
            }
            ?>

        </div>
    </main>
</body>