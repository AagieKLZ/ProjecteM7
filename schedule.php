<?php
session_start();
session_get_cookie_params();
include './api/lines.php';
include "./api/route.php";
error_reporting(0);

use api\lines;
use api\route;

if (isset($_GET['origin'])) {
    $origin = (int) $_GET['origin'];
    $origin_st = route::getStationNameById($origin)[0]['name'];
}
if (isset($_GET['destiny'])) {
    $destiny = (int) $_GET['destiny'];
    $destiny_st = route::getStationNameById($destiny)[0]['name'];
}

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
    <main class="flex flex-row justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[5rem]">
        <div class="w-full h-fit flex flex-col items-center justify-center">
            <div class="w-[90%] rounded-lg h-fit bg-fuchsia-100 bg-opacity-25 backdrop-blur p-8 py-6 drop-shadow-xl">
                <h1 class="font-semibold text-2xl">Consulta de horarios</h1>
                <form method="post" action="./lib/schedule.php" class="flex lg:flex-row flex-col min-w-fit justify-around lg:items-end items-center lg:space-y-0 space-y-2 w-full mt-8">
                    <div class="flex flex-col space-y-1">
                        <label for="origin" class="font-semibold">Origen</label>
                        <input autocomplete="off" value="<?= $origin_st ?>" required list="origin-list" id="origin" name="origin" class="w-44 bg-white px-2 h-12 rounded-lg border-2 border-fuchsia-900">
                        <datalist id="origin-list">
                            <?php
                            $stations = lines::getAllStations();
                            foreach ($stations as $station) : ?>
                                <option value='<?= $station["name"] ?>'></option>";

                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="destiny">Destino</label>
                        <input autocomplete="off" value="<?= $destiny_st ?>" required list="destiny-list" id="destiny" name="destiny" class="w-44 bg-white px-2 h-12 rounded-lg border-2 border-fuchsia-900">
                        <datalist name="destiny" id="destiny-list">
                            <?php
                            $stations = lines::getAllStations();
                            foreach ($stations as $station) : ?>
                                <option value='<?= $station["name"] ?>'></option>";

                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="date">Fecha</label>
                        <input required type="date" name="date" id="date" class="w-44 bg-white px-2 h-12 rounded-lg border-2 border-fuchsia-900">
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="time">Hora</label>
                        <select name="time" id="time" placeholder="----" class="w-44 bg-white h-12 px-2 rounded-lg border-2 border-fuchsia-900">
                            <?php
                            // Add 0s to hours lower than 10
                            for ($i = 0; $i < 24; $i++) : ?>
                                <?php if ($i < 10) {
                                    $i = "0" . $i;
                                }
                                ?>
                                <?php
                                $hour = date("H");
                                if (!isset($_GET["time"])) : ?>
                                    <option <?= $i == $hour ? "selected" : "" ?> value='<?= $i ?>:00'><?= $i ?>:00</option>
                                <?php else : ?>

                                    <option <?= !isset($_GET["time"]) ? "" : ($i . ":00" == $_GET["time"] ? "selected" : "") ?> value='<?= $i ?>:00'><?= $i ?>:00</option>
                                <?php endif; ?>
                            <?php endfor;
                            ?>
                        </select>
                    </div>
                    <button class="bg-gray-200 active:animate-pulse bg-opacity-75 hover:bg-fuchsia-900 hover:text-white text-black border-2 font-semibold border-black w-fit px-10 h-12 rounded-lg flex justify-between items-center md:text-xl text-lg">
                        Buscar
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </form>
            </div>
            <?php
            if (isset($_GET["origin"]) && isset($_GET["destiny"])) : ?>
                <div class="flex flex-row justify-between w-2/3 mt-6 text-lg">
                    <div><b>Origen: </b> <?= route::getStationNameById($_GET['origin'])[0]["name"] ?></div>
                    <div><b>Destino: </b> <?= route::getStationNameById($_GET['destiny'])[0]["name"] ?></div>
                </div>
                <div class="flex flex-row justify-between w-2/3 mt-2 text-lg">
                    <div><b>Fecha: </b> <?php echo $_GET['date'] ?></div>
                    <div><b>Hora: </b> <?php echo $_GET['time'] ?></div>
                </div>
                <div>
                    <a href="schedule.php?origin=<?= $_GET["destiny"] ?>&destiny=<?= $_GET["origin"] ?>&time=<?= $_GET["time"] ?>&date=<?= $_GET["date"] ?>" class="block drop-shadow-xl hover:bg-fuchsia-900 hover:text-white hover:stroke-white flex justify-center items-center px-2 border border-2 border-fuchsia-900 text-fuchsia-900 h-12 w-52 rounded-lg font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mr-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                        </svg>

                        Horarios de vuelta
                    </a>
                </div>
                <div class="flex mt-6 flex-row justify-between md:px-24 px-0 w-[90%] text-lg font-bold text-center border-b border-black">
                    <div class="py-1 text-center">Línea</div>
                    <div class="py-1 text-center">Salida</div>
                    <div class="py-1 text-center">Llegada</div>
                    <div class="py-1 text-center">Duración</div>
                </div>
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $schedules = route::calculateRoute($_GET['origin'], $_GET['destiny'], $_GET['time'], $page);
                $schedule_n = route::getNumberOfRoutes($_GET['origin'], $_GET['destiny'], $_GET['time']);
                if ($schedule_n == 0) : ?>
                    <div class='flex flex-col justify-center items-center mt-10 w-full h-full'>
                        <h1 class='text-2xl font-bold'>No hay horarios disponibles</h1>
                        <a href='./index.php' class='bg-fuchsia-900 block text-center mt-4 px-5 py-2 text-white font-semibold rounded-lg'>
                            Volver
                        </a>
                        <p class='mt-4 text-gray-600'>Las dos estaciones seleccionadas no están conectadas</p>

                    <?php endif; ?>

                    <?php
                    foreach ($schedules as $s) :
                    ?>
                        <div class="flex mt-6 flex-row justify-between md:px-24 px-0 w-[90%] text-lg text-center">
                            <div class="
                    <?= $s["colour"] ?> <?= $s["colour"] == 'bg-yellow-300' ? 'text-black' : 'text-white' ?>
                    w-[50px] h-[50px] flex items-center justify-center">
                                <?= $s['route_id'] ?>
                            </div>
                            <div class="flex items-center py-1 text-center"><?= $s['origin_time'] ?></div>
                            <div class="flex items-center py-1 text-center">
                                <?= $s['destiny_time'] ?>
                            </div>
                            <div class="flex items-center py-1 text-center">
                                <?php
                                $date1 = new DateTime($s['origin_time']);
                                $date2 = new DateTime($s['destiny_time']);
                                $diff = $date2->diff($date1);
                                echo $diff->format('%H:%I');
                                ?>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    $path = "./schedule.php?origin=" . $_GET['origin'] . "&destiny=" . $_GET['destiny'] . "&date=" . $_GET['date'] . "&time=" . $_GET['time'];
                    ?>
                    <?php if ($schedule_n > 0) : ?>
                        <div class="w-fit h-16 flex justify-center items-center rounded-full text-lg px-3">
                            <?php if ($page > 1) : ?>
                                <a href="<?= $path . "&page=" . ($page - 1) ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white hover:font-semibold <?= $page == 1 ? "bg-fuchsia-900 text-white" : "bg-white" ?>">
                                    < </a>
                                    <?php endif; ?>
                                    <?php for ($i = 0; $i < floor($schedule_n / 10); $i++) : ?>
                                        <a href="<?= $path . "&page=" . ($i + 1) ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white <?= $i + 1 == $page ? "bg-fuchsia-900 text-white font-semibold" : "bg-white" ?>"><?= $i + 1 ?></a>
                                    <?php endfor; ?>
                                    <?php if ($page < floor($schedule_n / 10)) : ?>
                                        <a href="<?= $path . "&page=" . ($page + 1) ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white hover:font-semibold <?= $page == count($stations) / 10 ? "bg-fuchsia-900 text-white" : "bg-white" ?>">></a>
                                    <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
    </main>
    <script>
        // Get today's date
        const today = new Date().toISOString().substr(0, 10);

        // Set the value of the date input field to today's date
        document.querySelector("input[type=date]").value = today;
        const form = document.querySelector("form");

        const station_list = document.querySelector("#origin-list");
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const origin = document.querySelector("#origin");
            const destiny = document.querySelector("#destiny");
            let origin_value = origin.value;
            let destiny_value = destiny.value;
            let origin_valid = false;
            let destiny_valid = false;
            for (let i = 0; i < station_list.options.length; i++) {
                if (station_list.options[i].value == origin_value) {
                    origin_valid = true;
                }
                if (station_list.options[i].value == destiny_value) {
                    destiny_valid = true;
                }
            }
            if (origin_valid && destiny_valid && origin_value !== destiny_value) {
                form.submit();
            } else if (origin_value === destiny_value) {
                alert("La estación de origen y destino no pueden ser iguales");
            } else {
                alert("Por favor, seleccione una estación válida");
            }
        })
    </script>
    <?php include("./components/searchModal.php") ?>
</body>

</html>