<?php
session_start();
session_get_cookie_params();
error_reporting(-1);
ini_set('display_errors', 'On');
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
        <div class="flex flex-col items-center w-full w-2/3 pb-4">
            <div class="w-full text-center text-4xl font-bold h-52 flex justify-center items-center station-main text-white">
                Estaciones
            </div>
            <div class="flex flex-row justify-evenly px-4 items-center w-full text-center text-xl font-semibold border-b border-b-black py-2">
                <div class="w-1/2 text-left px-10 py-1">Estación</div>
                <div class="w-1/2 py-1">Correspondencias</div>
            </div>
            <?php
            include './api/lines.php';

            use api\lines;

            
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $stations = lines::getAllStationsWithConnections();
            foreach ($stations as $i => $station) : ?>
            <?php if ($i > ($page - 1) * 10 && $i <= ($page) * 10): ?>
                <div class="flex flex-row justify-evenly px-4 <?= $i % 2 == 0 ? "bg-white" : "bg-gray-100" ?> items-center w-full py-4 text-center text-xl">
                    <div class="w-1/2 text-left">
                        <?= $station["name"]; ?>
                    </div>
                    <div class="flex flex-row flex-wrap max-w-lg min-w-md justify-center font-semibold w-1/2">
                        <?php foreach ($station["connections"] as $connection) : ?>
                            <div class="<?= $connection['colour'] ?> <?= $connection['colour'] == 'bg-yellow-300' ? 'text-black' : 'text-white'?> flex justify-center items-center py-2 px-2 mx-2">
                                <?= $connection["route_id"]; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php endforeach; ?>
            <div class="w-fit h-16 flex justify-center items-center rounded-full text-lg px-3">
                <?php if ($page > 1) : ?>
                <a href="stations.php?page=<?= $page - 1 ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white hover:font-semibold <?= $page == 1 ? "bg-fuchsia-900 text-white" : "bg-white" ?>"><</a>
                <?php endif; ?>
                <?php for($i = 0; $i < count($stations) / 10; $i++) : ?>
                    <a href="stations.php?page=<?= $i + 1 ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white <?= $i + 1 == $page ? "bg-fuchsia-900 text-white font-semibold" : "bg-white" ?>"><?= $i + 1 ?></a>
                <?php endfor; ?>
                <?php if ($page < count($stations) / 10) : ?>
                <a href="stations.php?page=<?= $page + 1 ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white hover:font-semibold <?= $page == count($stations) / 10 ? "bg-fuchsia-900 text-white" : "bg-white" ?>">></a>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include ("./components/searchModal.php") ?>
</body>