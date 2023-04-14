<?php
session_start();
session_get_cookie_params();
if (!isset($_SESSION['user'])) { header('Location: ../index.php'); }
include("../api/users.php");
use api\users;
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
    <main class="flex flex-col justify-center items-center w-full h-[calc(100vh-7rem)] mt-[3.5rem]">
        <div class="text-4xl mt-8 font-semibold">Editar Usuario</div>
        <?php if (!isset($_GET['id'])) : ?>
            <div class="text-red-600 font-semibold mt-16 text-2xl">404: El usuario no existe</div>
            <a href="../users.php" class="flex items-center mt-8 px-3 py-2 text-white bg-fuchsia-900 w-fit font-semibold rounded-lg ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>

                Volver
            </a>
        <?php else: ?>
            <?php $user = users::getUserById($_GET['id']); ?>
            <form class="mt-8 w-1/2" method="POST" action="../lib/editUser.php">
                <input type="hidden" value="<?=$_GET['id']?>" name="id" id="id">
                <label for="name">Nombre</label>
                <input name="name" id="name" type="text" value="<?=$user["name"]?>" class="w-full p-2 rounded-lg border border-fuchsia-900">
                <label for="email" class="block mt-8">Correo</label>
                <input pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" name="email" id="email" type="email" value="<?=$user["email"]?>" class="w-full p-2 rounded-lg border border-fuchsia-900">
            
                <input type="submit" value="Actualizar" class="mt-8 px-3 py-3 text-white bg-fuchsia-900 hover:bg-fuchsia-800 cursor-pointer w-full font-semibold rounded-lg">
               
            </form>
        <?php endif ?>
    </main>