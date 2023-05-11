<?php
session_start();
session_get_cookie_params();
if (!isset($_SESSION['user'])) {
    header('Location: ./index.php');
}
$current_user = $_SESSION["user"];
include '../api/lines.php';

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

    <?php include '../components/altNavbar.php'; ?>
    <main class="flex flex-col justify-center items-center w-2/3 mx-auto h-[calc(100%-3.5rem)] mt-[3.5rem]">
        <div class="mt-16 mb-8 text-3xl font-semibold">Administración de Estaciones</div>
        <form class="flex flex-row space-x-4" method="POST" action="create.php">
            <label for="station" class="py-1">Nombre</label>
            <input type="text" required name="station" id="station" class="w-44 bg-white px-2 h-fit py-1 rounded-lg border-2 border-fuchsia-900">
            <button type="submit" class="py-1 flex flex-row space-x-2 h-fit px-6 bg-transparent text-emerald-600 font-semibold border-2 hover:bg-emerald-600 hover:text-white border-emerald-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Añadir Estación
            </button>
            </div>
        </form>
        <div class="flex flex-row justify-evenly px-4 items-center w-full text-center text-xl font-semibold border-b border-b-black py-2">
            <div class="w-1/3 text-left px-10 py-1">Estación</div>
            <div class="w-1/3 py-1">Correspondencias</div>
            <div class="w-1/3 py-1"></div>
        </div>
        <?php
        $pages = lines::getStationNumber() / 10;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $stations = lines::getAllStationsWithConnectionsPaginated($page);
        foreach ($stations as $i => $station) : ?>
            <div class="flex flex-row justify-evenly px-4 <?= $i % 2 == 0 ? "bg-white" : "bg-gray-100" ?> items-center w-full py-4 text-center text-xl">
                <div class="w-1/3 text-left">
                    <?= $station["name"]; ?>
                </div>
                <div class="flex flex-row flex-wrap max-w-lg min-w-md justify-center font-semibold w-1/3">
                    <?php foreach ($station["connections"] as $connection) : ?>
                        <div class="<?= $connection['colour'] ?> <?= $connection['colour'] == 'bg-yellow-300' ? 'text-black' : 'text-white' ?> flex justify-center items-center py-2 px-2 mx-2">
                            <?= $connection["route_id"]; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="flex flex-row justify-center w-1/3 space-x-4">
                    <a href="./edit.php?id=<?= $station["id"] ?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-emerald-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg></a>
                    <a href="./delete.php?id=<?= $station["id"] ?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="w-fit h-16 flex justify-center items-center rounded-full text-lg px-3">
            <?php if ($page > 1) : ?>
                <a href="./view.php?page=<?= $page - 1 ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white hover:font-semibold <?= $page == 1 ? "bg-fuchsia-900 text-white" : "bg-white" ?>">
                    << /a>
                    <?php endif; ?>
                    <?php for ($i = 0; $i < $pages; $i++) : ?>
                        <a href="./view.php?page=<?= $i + 1 ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white <?= $i + 1 == $page ? "bg-fuchsia-900 text-white font-semibold" : "bg-white" ?>"><?= $i + 1 ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $pages) : ?>
                        <a href="./view.php?page=<?= $page + 1 ?>" class="px-4 py-2 block hover:bg-fuchsia-900 hover:text-white hover:font-semibold <?= $page == count($stations) / 10 ? "bg-fuchsia-900 text-white" : "bg-white" ?>">></a>
                    <?php endif; ?>
        </div>
        </div>
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
                            case 'create':
                                echo "Estación creada correctamente";
                                break;
                            case 'edit':
                                echo "Estación editada correctamente";
                                break;
                            case 'delete':
                                echo "Estación eliminada correctamente";
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
                            case 'create':
                                echo "Error al crear la estación";
                                break;
                            case 'edit':
                                echo "Error al editar la estación";
                                break;
                            case 'delete':
                                echo "Error al eliminar la estación";
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
</body>

</html>