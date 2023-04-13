<?php
session_start();
session_get_cookie_params();
include './api/lines.php';
include "./api/route.php";

use api\lines;
use api\route;

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
            <form method="post" action="./lib/schedule.php"
                  class="flex lg:flex-row flex-col min-w-fit justify-around lg:items-end items-center lg:space-y-0 space-y-2 w-full mt-8">
                <div class="flex flex-col space-y-1">
                    <label for="origin" class="font-semibold">Origen</label>
                    <input required list="origin-list" id="origin" name="origin" placeholder="----"
                           class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                    <datalist id="origin-list">
                        <?php
                        $stations = lines::getAllStations();
                        foreach ($stations as $station) {
                            echo "<option value='" . $station["name"] . "'></option>";
                        }
                        ?>
                    </datalist>
                </div>
                <div class="flex flex-col space-y-1">
                    <label for="destiny">Destino</label>
                    <input required list="destiny-list" id="destiny" name="destiny" placeholder="----"
                           class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                    <datalist name="destiny" id="destiny-list">
                        <?php
                        $stations = lines::getAllStations();
                        foreach ($stations as $station) {
                            echo "<option value='" . $station["name"] . "'></option>";
                        }
                        ?>
                    </datalist>
                </div>
                <div class="flex flex-col space-y-1">
                    <label for="date">Fecha</label>
                    <input required type="date" name="date" id="date"
                           class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                </div>
                <div class="flex flex-col space-y-1">
                    <label for="time">Hora</label>
                    <select name="time" id="time" placeholder="----"
                            class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                        <?php
                        // Add 0s to hours lower than 10
                        for ($i = 0; $i < 24; $i++) {
                            if ($i < 10) {
                                $i = "0" . $i;
                            }
                            echo "<option value='" . $i . ":00'>" . $i . ":00</option>";
                        }
                        ?>
                    </select>
                </div>
                <button
                    class="bg-gray-200 active:animate-pulse bg-opacity-75 hover:bg-fuchsia-900 hover:text-white text-black border-2 font-semibold border-black w-fit px-10 py-2 rounded-lg flex justify-between items-center md:text-xl text-lg">
                    Buscar
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                         stroke="currentColor" class="w-6 h-6 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
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
            <div
                class="flex mt-6 flex-row justify-between md:px-24 px-0 w-[90%] text-lg font-bold text-center border-b border-black">
                <div class="py-1">Línea</div>
                <div class="py-1">Salida</div>
                <div class="py-1">Llegada</div>
                <div class="py-1">Duración</div>
            </div>
            <?php
            $schedules = route::calculateRoute($_GET['origin'], $_GET['destiny'], $_GET['time']);
            // SHow php errors
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            // Foreach schedule
            foreach ($schedules as $s):
                ?>
                <div class="flex mt-6 flex-row justify-between md:px-24 px-0 w-[90%] text-lg text-center">
                    <div class="bg-fuchsia-800 text-white w-[50px] h-[50px] flex items-center justify-center">
                        <?= $s['route_id'] ?>
                    </div>
                    <div class="flex items-center py-1 text-center"><?= $s['time'] ?></div>
                    <div class="flex items-center py-1 text-center"><?php
                            if ($_GET['origin']<$_GET['destiny']){
                                echo route::getTimeByTrainNumPassingByStation($s['train_num'],$_GET['destiny'])[0]['time'];
                            }else{
                                echo route::getTimeByTrainNumPassingByStation($s['train_num'],$_GET['origin'])[0]['time'];
                            }
                        ?></div>
                    <div class="flex items-center py-1 text-center">
                        <?php
                        try {
                            $time1 = new DateTime($s['time']);
                            if ($_GET['origin']<$_GET['destiny']){
                                $time2 = new DateTime(route::getTimeByTrainNumPassingByStation($s['train_num'],$_GET['destiny'])[0]['time']);
                            }else{
                                $time2 = new DateTime(route::getTimeByTrainNumPassingByStation($s['train_num'],$_GET['origin'])[0]['time']);
                            }
                            $interval = $time1->diff($time2);
                            echo $interval->format('%H:%I').'h';
                        } catch (Exception $e) {
                            echo '?';
                        }
                        ?>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        <?php else: ?>
            <!-- Replace this with condition if no results found and show no text if the variables are not set -->
            <div class="mt-24 text-2xl max-w-[90%] text-center">No se encuentran horarios con las condiciones
                seleccionadas
            </div>

        <?php endif; ?>
</main>
</body>

</html>