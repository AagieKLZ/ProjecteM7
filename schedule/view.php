<?php
session_start();
session_get_cookie_params();
if (!isset($_SESSION['user'])) { header('Location: ../index.php'); }
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
        <div class="mb-8 mt-16 text-3xl font-semibold">Administración de Horarios</div>
        <form class="md:w-2/3 space-x-8 w-[90%] flex flex-row items-center justify-center">
            <div>
                <label for="lane" class="text-lg">Línea</label>
                <select class="ml-2 px-8 text-center py-2 rounded-lg" name="lane">
                <option>R1</option>
                <option>R2</option>
                </select>
            </div>
            <?php if(isset($_GET['lane'])) : ?>
            <div>
                <label for="direction" class="text-lg">Dirección</label>
                <select class="ml-2 px-8 text-center py-2 rounded-lg" name="direction">
                    <option>IDA</option>
                    <option>VUELTA</option>
                </select>
            </div>
            <?php endif; ?>
            <input type="submit" value="Buscar" class="px-5 py-2 text-white bg-fuchsia-900 rounded-lg font-semibold">
</form>