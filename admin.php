<?php
session_start();
session_get_cookie_params();
if (!isset($_SESSION['user'])) {
    header('Location: ./index.php');
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
    <link rel="stylesheet" href="styles.css">

</head>

<body class="mt-5">

    <?php include 'components/navbar.php'; ?>
    <?php include 'components/adminBg.php'; ?>

    <main class="flex flex-col justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[3.5rem]">
        <div class="mb-8 mt-16 text-3xl font-semibold">Panel de Administración</div>
        <div class="md:w-3/4 w-[90%] h-[50vh] grid grid-cols-2 place-items-center gap-12 mt-24">
            <a href="./schedule/view.php" id="schedule-card" class="card block grid grid-rows-2 bg-gray-100 bg-opacity-50 hover:bg-fuchsia-100 hover:bg-opacity-25 drop-shadow-xl backdrop-blur grid-cols-2 items-end border-2 border-blue-600 h-full w-full rounded-2xl text-blue-600">
                <div class="w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 relative inset-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div>
                <div></div>
                <div class="lg:block hidden"></div>
                <div class="text-right p-4 md:text-2xl text-xl font-semibold">Administrar Horarios</div>
                <div class="lg:hidden block"></div>
            </a>
            <a href="./users.php" id="user-card" class="card block grid grid-rows-2 grid-cols-2 bg-gray-100 hover:bg-green-100 hover:bg-opacity-25 bg-opacity-50 drop-shadow-xl backdrop-blur items-end border-2 border-emerald-600 h-full w-full rounded-2xl text-emerald-600">
                <div class="w-full h-full">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 relative inset-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>

                </div>
                <div></div>
                <div class="lg:block hidden"></div>
                <div class="text-right p-4 md:text-2xl text-xl font-semibold">Administrar Usuarios</div>
                <div class="lg:hidden block"></div>
            </a>
            <a href="./lines/view.php" id="train-card" class="card block grid grid-rows-2 bg-gray-100 bg-opacity-50 hover:bg-indigo-100 hover:bg-opacity-25 drop-shadow-xl backdrop-blur grid-cols-2 items-end border-2 border-rose-600 h-full w-full rounded-2xl text-rose-600">
                <div class="w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 relative inset-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z" />
                    </svg>

                </div>
                <div></div>
                <div class="lg:block hidden"></div>
                <div class="text-right p-4 md:text-2xl text-xl font-semibold">Administrar Líneas</div>
                <div class="lg:hidden block"></div>
            </a>
            <a href="./stations/view.php" id="station-card" class="card block grid grid-rows-2 grid-cols-2 bg-gray-100 hover:bg-orange-100 hover:bg-opacity-25 bg-opacity-50 drop-shadow-xl backdrop-blur items-end border-2 border-orange-800 h-full w-full rounded-2xl text-orange-800">
                <div class="w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 relative inset-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>


                </div>
                <div></div>
                <div class="lg:block hidden"></div>
                <div class="text-right p-4 md:text-2xl text-xl font-semibold">Administrar Estaciones</div>
                <div class="lg:hidden block"></div>
            </a>
        </div>
    </main>
    <?php include("./components/searchModal.php") ?>
</body>

</html>