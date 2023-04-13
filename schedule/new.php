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
            <form class="md:w-2/3 space-x-8 w-[90%] flex flex-col items-center justify-center" action="../lib/createRoute.php" method="POST">
                <div class="flex flex-row justify-around w-full border-b pb-6 my-4 text-lg items-center">
                    <div><b>Línea:</b> <?= $_GET["lane"] ?></div>
                    <div><b>Origen:</b> <?= $_GET["origin"] ?></div>
                    <div><b>Destino:</b> <?= $_GET["destiny"] ?></div>
                </div>
                <div class="flex flex-row items-center justify-center w-full space-x-24 border-b pb-6">
                    <div class="space-x-3">
                        <label for="origin" class="text-lg font-semibold">Salida</label>
                        <input type="text" name="departure" id="departure" value="14:24" class="w-32 text-center border rounded-lg">
                    </div>
                    <div class="space-x-3">
                        <label for="destination" class="text-lg font-semibold">Llegada</label>
                        <input type="text" name="destination" id="destination" value="15:41" class="w-32 text-center border rounded-lg" disabled>
                        <input type="hidden" name="arrival">
                    </div>
                    <div class="space-x-3">
                        <label for="duration" class="text-lg font-semibold">Tiempo entre paradas</label>
                        <select name="duration" id="duration" value="3:00" class="w-32 text-center border rounded-lg" list="time-list">
                            <option value="3">3:00</option>
                            <option value="4">4:00</option>
                            <option value="5">5:00</option>
                        </select>
                    </div>
                    <button type="submit" class="rounded-lg px-5 py-2 bg-fuchsia-900 text-white font-semibold">Guardar</button>
                </div>
                <div class="grid w-full grid-cols-4 mt-4 mb-8 gap-14">
                    <?php

                    $stations = lines::getAllStationsBetween($_GET['origin'], $_GET['destiny']);
                    foreach ($stations as $station) :
                    ?>
                        <div class="flex flex-row items-center justify-start space-x-3">
                            <input type="checkbox" <?= $station["name"] == $_GET['origin'] || $station["name"] == $_GET["destiny"] ? "disabled" : "" ?> name="<?= $station['id'] ?>" id="<?= $station['id'] ?>" class="accent-fuchsia-900" checked>
                            <label for="<?= $station['id'] ?>" class="ml-2 text-lg font-semibold select-none"><?= $station['name'] ?></label>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
                <input type="hidden" id="lane" name="lane" value="<?= $_GET['lane'] ?>">
                <input type="hidden" id="origin_id" name="origin_id" value="<?= $stations[0]["id"] ?>">
                <input type="hidden" id="destiny_id" name="destiny_id" value="<?= $stations[count($stations) - 1]["id"] ?>">
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
    <script>
        const boxes = document.querySelectorAll("input[type='checkbox']");
        const duration = document.querySelector("#duration");
        calculateDuration();

        function calculateDuration() {
            const checked = document.querySelectorAll("input[type='checkbox']:checked");
            const time = (checked.length - 1) * duration.value;
            const hours = Math.floor(time);
            const minutes = Math.round((time - hours) * 60);
            const origin = document.querySelector("#departure").value;
            document.querySelector("#destination").value = addMinutes(origin, time);
            document.querySelector("input[name='arrival']").value = addMinutes(origin, time);
        }

        function addMinutes(time, minutes) {
            var timeParts = time.split(":");
            var hours = parseInt(timeParts[0]);
            var mins = parseInt(timeParts[1]);
            var totalMinutes = hours * 60 + mins + minutes;
            var newHours = Math.floor(totalMinutes / 60);
            var newMinutes = totalMinutes % 60;
            return pad(newHours) + ":" + pad(newMinutes);
        }

        function pad(value) {
            return (value < 10) ? "0" + value : value;
        }

        boxes.forEach(box => {
            box.addEventListener("change", () => {
                console.log("changed")
                calculateDuration()
            });
        });
        duration.addEventListener("change", calculateDuration)
        origin.addEventListener("change", calculateDuration)
    </script>
</body>

</html>