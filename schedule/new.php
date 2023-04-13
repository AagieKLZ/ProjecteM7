<?php
session_start();
session_get_cookie_params();
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
}
include("../api/lines.php");
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
    <link rel="stylesheet" href="../styles.css">


</head>

<body class="mt-5">
    <?php include '../components/altNavbar.php' ?>
    <main class="flex flex-col justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[3.5rem]">
        <div class="mt-16 mb-8 text-3xl font-semibold">Añadir Horario</div>
        <?php if (isset($_GET['direction']) && isset($_GET['lane']) && isset($_GET['origin']) && isset($_GET['destiny'])) : ?>
            <form class="md:w-2/3 space-x-8 w-[90%] flex flex-col items-center justify-center">
                <div class="flex flex-row items-center justify-center w-full space-x-24">
                    <div class="space-x-3">
                    <label for="origin" class="text-lg font-semibold">Salida</label>
                    <input type="text" name="origin" id="origin" value="14:24" class="w-32 text-center border rounded-lg">
                    </div>
                    <div class="space-x-3">
                        <label for="destination" class="text-lg font-semibold">Llegada</label>
                        <input type="text" name="destination" id="destination" value="15:41" class="w-32 text-center border rounded-lg" disabled>
                    </div>
                    <div class="space-x-3">
                        <label for="duration" class="text-lg font-semibold">Tiempo entre paradas</label>
                        <select name="duration" id="duration" value="3:00" class="w-32 text-center border rounded-lg" list="time-list">
                            <option value="3">3:00</option>
                            <option value="3.5">3:30</option>
                            <option value="4">4:00</option>
                            <option value="4.5">4:30</option>
                            <option value="5">5:00</option>
                            <option value="5.5">5:30</option>
                        </select>
                    </div>
                </div>
                <div class="grid w-full grid-cols-4 mt-12 mb-8 gap-14">
                    <!-- <?php for($i=1; $i<24; $i++) : ?>
                        <div class="flex flex-row items-center justify-start space-x-3">
                            <input type="checkbox" name="p<?php echo $i?>" id="p<?php echo $i?>" class="accent-fuchsia-900" checked>
                            <label for="p<?php echo $i?>" class="ml-2 text-lg font-semibold">Parada <?php echo $i ?></label>
                        </div>
                    <?php endfor; ?> -->
                    <?php
                        
                        $stations = lines::getAllStationsBetween($_GET['origin'], $_GET['destiny']);
                        foreach($stations as $station):
                        ?>
                        <div class="flex flex-row items-center justify-start space-x-3">
                            <input type="checkbox" name="p<?php echo $station['id']?>" id="p<?php echo $station['id']?>" class="accent-fuchsia-900" checked>
                            <label for="p<?= $station['id']?>" class="ml-2 text-lg font-semibold"><?php echo $station['name'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>
        <?php else : ?>
            <div class="text-lg">No se ha seleccionado una línea y/o dirección</div>
            <a href="./view.php" class="flex items-center px-3 py-2 mt-8 font-semibold text-white rounded-lg bg-fuchsia-900 w-fit ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>

                Volver
            </a>
        <?php endif; ?>
    </main>
</body>
</html>