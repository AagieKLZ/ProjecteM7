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
        <div class="mt-8 text-4xl font-semibold">Eliminar Horario</div>
        <?php if (!isset($_GET['id'])) : ?>
            <div class="mt-16 text-2xl font-semibold text-red-600">404: El horario no existe</div>
            <a href="./view.php" class="flex items-center px-3 py-2 mt-8 font-semibold text-white rounded-lg bg-fuchsia-900 w-fit ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>

                Volver
            </a>
        <?php else: ?>
            <div class="mt-32 text-xl">Eliminar horario</div>
            <div class="text-xl font-semibold text-fuchsia-900">Reus - Barcelona-Sants</div>
            <div class="text-xl font-semibold text-fuchsia-900">14:04 - 15:21</div>
            <form class="flex justify-between w-2/12 mt-4">
                <input type="submit" class="px-3 py-2 text-lg font-semibold text-white rounded-lg cursor-pointer bg-emerald-500 hover:bg-emerald-600" value="Confirmar" />
                <a class="px-3 py-2 text-lg font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700" href="../users.php">Cancelar</a>
            </form>
        <?php endif ?>