<?php
    $_SESSION["errorCode"] = "";
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

<body>

    <?php include 'components/navbar.php'; ?>
    <?php include 'components/background.php'; ?>
    <main class="flex flex-row justify-center items-center w-full h-[calc(100%-3.5rem)] absolute top-14 bg-gradient from-white to-gray-200">
        
    <form action="./lib/login.php" method="POST" class="lg:w-1/3 md:w-1/2 w-2/3 h-fit py-24 flex flex-col justify-center items-center bg-gray-50 bg-opacity-50 backdrop-blur space-y-4 rounded-3xl drop-shadow-xl">
            <img src="./assets/logo.png" alt="Logo" class="w-1/3 -mt-16">
            <h1 class="text-xl font-semibold text-fuchsia-900">Acceso para administradores</h1>
            <div class="w-full flex flex-col justify-center items-center">
                <label for="username" class="block flex w-2/3 justify-start text-fuchsia-900 font-semibold">Email</label>
                <input type="email" name="username" id="username" class="w-2/3 h-10 text-fuchsia-900 font-light border-2 border-fuchsia-800 rounded-lg px-2">
            </div>
            <?php 
                if (isset($_SESSION["errorCode"]) && $_SESSION["errorCode"] == "404"){
                    echo "<div class='text-red-500 w-2/3 text-left italic'>Usuario o contraseña incorrectos</div>";
                }
            ?>
            <div class="w-full flex flex-col justify-center items-center">
                <label for="password" class="block flex w-2/3 justify-start text-fuchsia-900 font-semibold">Contraseña</label>
                <input type="password" name="password" id="password" class="w-2/3 text-fuchsia-900 h-10 border-2 border-fuchsia-800 rounded-lg px-2">
            </div>
            <a href="#" class="block text-fuchsia-900 underline w-2/3 flex flex-row justify-start items-center font-light">¿Has olvidado tu contraseña?</a>
            <button class="w-2/3 py-2 border-2 border-fuchsia-900 rounded-lg text-fuchsia-900 font-semibold hover:text-white hover:bg-fuchsia-900">Iniciar Sesión</button>
        </form>
    </main>


</body>

</html>