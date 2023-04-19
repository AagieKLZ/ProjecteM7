<?php
session_start();
session_get_cookie_params();
include './api/lines.php';
use api\lines;
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
        <div class="w-full text-center text-4xl font-bold h-52 flex justify-center items-center line-main text-white">Líneas</div>
            <div class="flex justify-center">
                <?php
                    $all_lanes = lines::getAllLines(); 
                    foreach($all_lanes as $lane):
                ?>
                    <a href="?lane=<?=$lane["name"] ?>" class="<?=$lane["colour"]?> block px-4 py-3 <?=$lane["colour"] == "bg-yellow-500" ? "text-black" : "text-white"?> font-semibold"><?=$lane["name"] ?></a>
                <?php endforeach; ?>
            </div>
            <div class="flex flex-row justify-evenly items-center w-full text-center text-xl font-semibold border-b border-b-black mb-2 py-2 mt-4">
                <div class="w-1/3 text-center">Linea</div>
                <div class="w-1/3 text-center">Origen</div>
                <div class="w-1/3 text-center">Destino</div>
            </div>
            <?php
            
            $lanes = lines::getLines();
            foreach ($lanes as $index => $lane) :?>
            <?php if(isset($_GET["lane"]) && $_GET["lane"] != $lane["route_id"]) continue; ?>
                    <div class="flex flex-row justify-evenly <?= $index % 2 == 0 ? "bg-white" : "bg-gray-100" ?> items-center w-full py-4">
                        <div class="w-1/3">
                        <div class="<?= $lane['colour']?> <?= $lane['colour'] == 'bg-yellow-300' ? 'text-black' : 'text-white'?> font-semibold w-[50px] mx-auto h-[50px] flex items-center justify-center">
                            <?= $lane['route_id'] ?>
                        </div>
                        </div>
                        <div class="w-1/3 text-center"><?= $lane['Origin'] ?></div>
                        <div class="w-1/3 text-center"><?= $lane['Destiny'] ?></div>
                    </div>
                
            <?php endforeach; ?>
        </div>

        <?php include ("./components/searchModal.php") ?>
    </main>
</body>