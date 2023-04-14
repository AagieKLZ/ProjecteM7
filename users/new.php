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
    <main class="flex flex-col justify-center items-center w-full h-[calc(100vh-7rem)] mt-[3.5rem]">
        <div class="text-4xl mt-8 font-semibold">Crear Usuario</div>
            <form class="mt-8 w-1/2" action="../lib/signup.php" method="POST">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" class="w-full p-2 rounded-lg border border-fuchsia-900">
                <label for="email" class="block mt-8">Correo</label>
                <input pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" type="email" id="email" name="email" class="w-full p-2 rounded-lg border border-fuchsia-900">
                <label for="password" class="block mt-8">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full p-2 rounded-lg border border-fuchsia-900">
                <label for="rpassword" class="block mt-8">Confirmar Contraseña</label>
                <input type="password" id="rpassword" name="rpassword" class="w-full p-2 rounded-lg border border-fuchsia-900">
                <div class="text-red-600 hidden" id="error">Las contraseñas no coinciden</div>
                <input type="submit" value="Crear Usuario" class="mt-8 px-3 py-3 text-white bg-fuchsia-900 hover:bg-fuchsia-800 cursor-pointer w-full font-semibold rounded-lg">
                
            </form>
    </main>
    <script>
        const password = document.getElementById('password');
        const rpassword = document.getElementById('rpassword');
        const submit = document.querySelector('input[type="submit"]');
        submit.disabled = true;
        rpassword.addEventListener('input', () => {
            const errormsg = document.getElementById('error');
            if (password.value === rpassword.value) {
                submit.disabled = false;
                errormsg.classList.add('hidden');
            } else {
                submit.disabled = true;
                errormsg.classList.remove('hidden');
            }
        })
    </script>