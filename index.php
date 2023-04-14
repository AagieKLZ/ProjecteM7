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

<body class="pt-16">

    <?php include 'components/navbar.php'; ?>
    <div class="fixed inset-0 z-[-1] mt-[3.5rem]">
        <img src="./assets/bgtrain.jpg" class="object-cover w-full h-full opacity-25" />
    </div>

    <main class="flex flex-row justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[5rem]">
        <div class="w-full h-fit flex flex-col items-center justify-center">
            <div class="w-full flex items-center justify-center -mt-12"><img src="./assets/logo.png" class="w-[170px]"></div>
            <div class="w-[90%] rounded-lg h-fit bg-fuchsia-100 bg-opacity-25 backdrop-blur p-8 py-6 drop-shadow-xl">
                <h1 class="font-semibold text-2xl">Consulta de horarios</h1>
                <form method="post" action="./lib/schedule.php" class="flex lg:flex-row flex-col min-w-fit justify-around lg:items-end items-center lg:space-y-0 space-y-2 w-full mt-8">
                    <div class="flex flex-col space-y-1">
                        <label for="origin" class="font-semibold">Origen</label>
                        <input autocomplete="off" required list="origin-list" id="origin" name="origin" class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
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
                        <input autocomplete="off" required list="destiny-list" id="destiny" name="destiny" class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
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
                        <input required type="date" name="date" id="date" class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="time">Hora</label>
                        <select name="time" id="time" placeholder="----" class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                            <?php
                            $hour = date("H");
                            // Add 0s to hours lower than 10
                            for ($i = 0; $i < 24; $i++) : ?>
                            <?php if ($i < 10) {
                                    $i = "0" . $i;
                                }
                            ?>
                                <option <?= $i == $hour ? "selected" : "" ?> value='<?= $i ?>:00'><?=$i?>:00</option>
                            <?php endfor;
                            ?>
                        </select>
                    </div>
                    <button class="bg-gray-200 active:animate-pulse bg-opacity-75 hover:bg-fuchsia-900 hover:text-white text-black border-2 font-semibold border-black w-fit px-10 py-2 rounded-lg flex justify-between items-center md:text-xl text-lg">
                        Buscar
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="flex flex-row justify-center items-center w-[90%] h-fit md:mt-32 mt-4 md:space-x-24 space-x-4 mb-4">
                <a href="./routes.php" class="bubble bubble1 flex flex-col justify-center items-center hover:font-semibold hover:scale-105">
                    <div class="lg:w-[175px] lg:h-[175px] w-[100px] h-[100px] drop-shadow-xl bg-emerald-500 hover:bg-emerald-600 rounded-full flex justify-center items-center">
                        <img src="assets/train.svg" class="lg:h-[75px] h-[50px]" />
                    </div>
                    <div class="lg:text-2xl text-lg mt-2 font-semibold">Líneas</div>
                </a>
                <a href="./schedule.php" class="bubble bubble2 flex flex-col justify-center items-center hover:font-semibold hover:scale-105">
                    <div class="lg:w-[175px] lg:h-[175px] w-[100px] h-[100px] drop-shadow-xl bg-emerald-500 hover:bg-emerald-600 rounded-full flex justify-center items-center">
                        <img src="assets/time.svg" class="lg:h-[75px] h-[50px]" />
                    </div>
                    <div class="lg:text-2xl text-lg mt-2 font-semibold">Horarios</div>
                </a>
                <a href="./stations.php" class="bubble bubble3 flex flex-col justify-center items-center hover:font-semibold hover:scale-105">
                    <div class="lg:w-[175px] lg:h-[175px] w-[100px] h-[100px] drop-shadow-xl bg-emerald-500 rounded-full hover:bg-emerald-600 flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="lg:h-[75px] h-[50px] stroke-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>

                    </div>
                    <div class="lg:text-2xl text-lg mt-2 font-semibold">Estaciones</div>
                </a>
            </div>
        </div>
    </main>
    <script>
        // Get today's date
        const today = new Date().toISOString().substr(0, 10);

        // Set the value of the date input field to today's date
        document.querySelector("input[type=date]").value = today;
        const form = document.querySelector("form");
        const origin = document.querySelector("#origin");
        const destiny = document.querySelector("#destiny");
        const station_list = document.querySelector("#origin-list");
        form.addEventListener("submit", (e) => {
            e.preventDefault();
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
            if (origin_valid && destiny_valid && origin_value != destiny_value) {
                form.submit();
            } else if (origin_value == destiny_value) {
                alert("La estación de origen y destino no pueden ser iguales");
            } else {
                alert("Por favor, seleccione una estación válida");
            }
        })
    </script>
</body>

</html>