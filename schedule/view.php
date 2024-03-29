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
                <select class="px-8 py-2 ml-2 text-center rounded-lg border border-fuchsia-900" name="lane" id="lane">
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
                    <select class="px-8 py-2 ml-2 text-center rounded-lg border border-fuchsia-900" name="direction" id="direction">
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
            <?php 
                $schedules = lines::getAllTrainsBetween($_GET["origin"], $_GET["destiny"]) 
            ?>
            <div class="mt-8 w-[90%] flex flex-col justify-start items-center mb-4">
                <div class="md:flex grid grid-cols-2 flex-row items-center justify-center w-full place-items-center gap-4 md:space-x-24 text-lg">
                    <div><b>Origen:</b> <?= $_GET["origin"] ?></div>
                    <div><b>Destino:</b> <?= $_GET["destiny"] ?></div>
                    <div><b>Horarios:</b> <?= count($schedules) ?></div>
                    <a href="./new.php?lane=<?= $_GET["lane"] ?>&direction=<?= $_GET["direction"] ?>&origin=<?= $_GET["origin"] ?>&destiny=<?= $_GET["destiny"] ?>" class="flex items-center justify-between px-3 py-1 font-semibold border border-2 rounded-lg w-fit hover:bg-emerald-500 text-emerald-500 hover:text-white hover:stroke-white stroke-emerald-500 border-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-2 stroke-inherit">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Añadir Horario
                    </a>
                </div>
                <div class="flex flex-row items-center justify-around w-full p-2 text-xl font-semibold text-center border-b border-b-black">
                    <div class="w-1/6 text-center">Linea</div>
                    <div class="w-1/6 text-center">Salida</div>
                    <div class="w-1/6 text-center">Llegada</div>
                    <div class="w-1/6 text-center">Paradas</div>
                    <div class="w-1/6 text-center">Duración</div>
                    <div class="w-1/6 text-center"></div>
                </div>
                <?php foreach ($schedules as $index => $schedule) : ?>
                    <form method="POST" action="./edit.php" class="flex flex-row py-4 items-center justify-around w-full text-lg text-center <?= $index % 2 == 0 ? "bg-gray-100" : "bg-white" ?>">
                        <div class="w-1/6 text-center">
                            <select name="line" id="line" class="w-24 bg-white border border-fuchsia-900 rounded-lg text-center py-1">
                                <?php
                                foreach ($lines as $line) : ?>
                                    <option value=<?= $line["name"] ?> <?= $line["name"] == $defaultLane ? "selected" : "" ?>><?= $line["name"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" name="direction" value="<?= $_GET["direction"] ?>">
                        <div class="w-1/6 text-center">
                            <input type="text" name="departure" id="departure" required value="<?= $schedule["departure_time"] ?>" class="text-center rounded-lg border-fuchsia-900 border w-24">
                        </div>
                        <div class="w-1/6 text-center">
                            <input type="text" name="arrival" id="arrival" required value="<?= $schedule["arrival_time"] ?>" class="text-center rounded-lg border border-fuchsia-900 w-24">
                        </div>
                        <div class="w-1/6 text-center"><?= $schedule["stops"] ?></div>
                        <div class="w-1/6 text-center">
                            <?php
                            $date1 = new DateTime($schedule["departure_time"]);
                            $date2 = new DateTime($schedule["arrival_time"]);
                            $diff = $date1->diff($date2);
                            echo $diff->format('%H:%I');
                            ?>
                        </div>
                        <input type="hidden" name="train_n" value="<?= $schedule["train_num"] ?>">
                        <input type="hidden" name="origin" value="<?= $_GET["origin"] ?>">
                        <input type="hidden" name="destiny" value="<?= $_GET["destiny"] ?>">
                        <div class="w-1/6 flex justify-center space-x-4">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-emerald-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                            <a href="./delete.php?train=<?= $schedule["train_num"] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                        </div>
                    </form>
                <?php endforeach ?>
            </div>
        <?php endif; ?>
    </main>
    <?php if (isset($_GET['success']) && $_GET['success'] == "true") : ?>
        <div class="toast fixed flex flex-col bottom-4 rounded-xl left-2 w-96 h-24 bg-emerald-500">
            <div class="h-4/5 flex flex-row justify-between items-center px-8 pt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <?php if (isset($_GET['action'])) : ?>
                    <span class="text-white font-semibold">
                        <?php
                        switch ($_GET['action']) {
                            case 'new':
                                echo "Ruta creada correctamente";
                                break;
                            case 'edit':
                                echo "Ruta editada correctamente";
                                break;
                            case 'delete':
                                echo "Ruta eliminada correctamente";
                                break;
                        }
                        ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="h-1/5 rounded-b-xl">
                <div class="w-full h-full rounded-b-xl bg-emerald-700 loader"></div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['success']) && $_GET['success'] == "false") : ?>
        <div class="toast fixed flex flex-col bottom-4 rounded-xl left-2 w-96 h-24 bg-red-500">
            <div class="h-4/5 flex flex-row justify-between items-center px-8 pt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <?php if (isset($_GET['action'])) : ?>
                    <span class="text-white font-semibold">
                        <?php
                        switch ($_GET['action']) {
                            case 'new':
                                echo "Error al crear la ruta";
                                break;
                            case 'edit':
                                echo "Error al editar la ruta";
                                break;
                            case 'delete':
                                echo "Error al eliminar la ruta";
                                break;
                        }
                        ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="h-1/5 rounded-b-xl">
                <div class="w-full h-full rounded-b-xl bg-red-700 loader"></div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])) : ?>
        <div class="toast fixed flex flex-col bottom-4 rounded-xl left-2 w-96 h-24 bg-red-600">
            <div class="h-4/5 flex flex-row justify-between items-center px-8 pt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span class="text-white font-semibold">Se ha producido un error</span>
            </div>
            <div class="h-1/5 rounded-b-xl">
                <div class="w-full h-full rounded-b-xl bg-red-800 loader"></div>
            </div>
        <?php endif; ?>
</body>

</html>