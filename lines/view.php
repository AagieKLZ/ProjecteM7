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
        <div class="mt-16 mb-8 text-3xl font-semibold">Administración de Líneas</div>
        <form class="flex flex-row space-x-4" method="POST" action="./create.php">
            <div class="flex flex-start items-center">
                <div class="px-2 py-1 border-2 border-fuchsia-900 bg-fuchsia-900 text-white font-semibold rounded-l-lg">R</div>
                <input type="number" min="1" name="lane" id="lane" class="w-20 bg-white px-2 h-fit py-1 rounded-r-lg border-2 border-fuchsia-900">
            </div>
            <select name="color" id="color" class="w-fit border-fuchsia-900 rounded-lg px-2 py-1 border-2">
                <?php
                $colors = lines::getColors();
                foreach ($colors as $color) :
                ?>
                    <option value="<?= $color ?>"><?= $color ?></option>
                <?php endforeach; ?>

            </select>
            <button type="submit" class="py-1 flex flex-row space-x-2 h-fit px-6 bg-transparent text-emerald-600 font-semibold border-2 hover:bg-emerald-600 hover:text-white border-emerald-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Añadir Línea
            </button>
            </div>
        </form>
        <?php $lines = lines::getAllLines(); ?>
        <div class="grid grid-cols-4 w-full h-full place-items-center gap-y-8 gap-x-4 mt-12">
            <?php foreach ($lines as $line) : ?>
                <form class="w-36 h-fit flex flex-col" method="POST" action="./update.php">
                    <div class="w-24 h-24 mx-auto top-0 left-0 text-lg font-semibold flex justify-center items-center drop-shadow-lg hover:scale-110 hover:shadow-xl <?= $line["colour"] ?> <?= $line["colour"] == "bg-yellow-300" ? "text-black" : "text-white" ?>"><?= $line["name"] ?></div>
                    <select name="color" class="border border-fuchsia-900 px-2 py-1 rounded-lg mt-1">
                        <option value="<?= $line["colour"]?>" selected><?= $line["colour"]?></option>
                        <?php foreach ($colors as $color) : ?>
                            <option value="<?= $color ?>"><?= $color ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="name" value="<?= $line["name"] ?>">
                    <div class="w-full flex justify-between items-center mt-1">
                        <button type="submit" class="w-1/2 h-12 flex justify-center items-center border-emerald-600 hover:bg-emerald-600 hover:stroke-white stroke-emerald-600 border-2 rounded-l-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-inherit">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                        <a href="./delete.php?name=<?=$line["name"]?>" class="w-1/2 h-12 flex justify-center items-center border-red-600 rounded-r-lg border-2 hover:bg-red-600 hover:stroke-white stroke-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-inherit">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </a>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    </main>
</body>