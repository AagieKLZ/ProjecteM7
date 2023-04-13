<?php
session_start();
session_get_cookie_params();
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
}
$defaultLane = "R1";
$defaultDirection = 0;
if (isset($_GET['lane'])) {
    $defaultLane = $_GET['lane'];
}
if (isset($_GET['direction'])) {
    $defaultDirection = $_GET['direction'];
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
    <link rel="stylesheet" href="../styles.css">


</head>

<body class="mt-5">
    <?php include '../components/altNavbar.php' ?>
    <main class="flex flex-col justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[3.5rem]">
        <div class="mt-16 mb-8 text-3xl font-semibold">Administración de Horarios</div>
        <form class="md:w-2/3 md:space-x-8 md:space-y-0 space-y-4 w-[90%] flex md:flex-row flex-col items-center justify-evenly">
            <div>
                <label for="lane" class="text-lg">Línea</label>
                <select class="px-8 py-2 ml-2 text-center rounded-lg" name="lane" id="lane">
                    <?php
                    include "../api/lines.php";

                    use api\lines;

                    $lines = lines::getDistinctLines();
                    foreach ($lines as $line) : ?>
                        <option value=<?= $line["name"] ?> <?= $line["name"] == $defaultLane ? "selected" : "" ?>><?= $line["name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="origin" value="" id="origin" />
                <input type="hidden" name="destiny" value="" id="destiny" />

            </div>
            <?php if (isset($_GET['lane'])) : ?>
                <div>
                    <label for="direction" class="text-lg">Dirección</label>
                    <select class="px-8 py-2 ml-2 text-center rounded-lg" name="direction" id="direction">
                        <?php
                        $directions = lines::getDirections($_GET["lane"]);
                        foreach ($directions as $index => $direction) : ?>
                            <option value=<?= $index ?> <?= $index == $defaultDirection ? "selected" : "" ?>><?= $direction["Origin"] ?> - <?= $direction["Destiny"] ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>
                <script>
                    const inp = document.getElementById("direction");
                    const origin = document.getElementById("origin");
                    const destiny = document.getElementById("destiny");
                    origin.value = inp.options[0].innerText.split(" - ")[0];
                    destiny.value = inp.options[0].innerText.split(" - ")[1];
                    inp.addEventListener("change", () => {
                        const options = inp.options
                        console.log(options)
                        const value = inp.value;
                        const selected = options[value].innerText;
                        const [originV, directionV] = selected.split(" - ");
                        origin.value = originV;
                        destiny.value = directionV;
                    });
                </script>
            <?php endif; ?>
            <input type="submit" value="Buscar" class="px-5 py-2 font-semibold text-white rounded-lg bg-fuchsia-900">
        </form>
        <?php if (isset($_GET['direction']) && isset($_GET['lane'])) : ?>
            <?php $schedules = lines::getAllTrainsBetween($_GET["origin"], $_GET["destiny"]) ?>
            <div class="mt-8 w-[90%] flex flex-col justify-start items-center mb-4">
                <div class="md:flex grid grid-cols-2 flex-row items-center justify-center w-full place-items-center gap-4 md:space-x-24 text-lg">
                    <div><b>Origen:</b> <?= $_GET["origin"] ?></div>
                    <div><b>Destino:</b> <?= $_GET["destiny"] ?></div>
                    <div><b>Horarios:</b> <?= count($schedules) ?></div>
                    <a href="./new.php?lane=1&direction=1" class="flex items-center justify-between px-3 py-1 font-semibold border border-2 rounded-lg w-fit hover:bg-emerald-500 text-emerald-500 hover:text-white hover:stroke-white stroke-emerald-500 border-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-2 stroke-inherit">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Añadir Horario
                    </a>
                </div>
                <div class="flex flex-row items-center justify-around w-full p-2 text-xl font-semibold text-center border-b border-b-black">
                    <div class="w-[25%]">Salida</div>
                    <div class="w-[25%]">Llegada</div>
                    <div class="w-[25%]">Paradas</div>
                    <div class="w-[25%]">Duración</div>
                </div>
                <?php foreach ($schedules as $index => $schedule) : ?>
                    <div class="flex flex-row py-4 items-center justify-around w-full text-lg text-center <?= $index % 2 == 0 ? "bg-gray-100" : "bg-white" ?>">
                        <div class="w-[25%]"><?= $schedule["departure_time"] ?></div>
                        <div class="w-[25%]"><?= $schedule["arrival_time"] ?></div>
                        <div class="w-[25%]"><?= $schedule["stops"] ?></div>
                        <div class="w-[25%]"><?php 
                            $date1 = new DateTime($schedule["departure_time"]);
                            $date2 = new DateTime($schedule["arrival_time"]);
                            $diff = $date1->diff($date2);
                            echo $diff->format('%H:%I');
                        ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>