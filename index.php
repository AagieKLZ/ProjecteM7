<?php
session_start();
session_get_cookie_params();
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

<body class="pt-16">

    <?php include 'components/navbar.php'; ?>
    <div class="fixed inset-0 z-[-1] mt-[3.5rem]">
        <img src="./assets/bgtrain.jpg" class="object-cover w-full h-full opacity-25" />
    </div>

    <main class="flex flex-row justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[5rem]">
        <div class="w-full h-fit flex flex-col items-center justify-center">
            <div class="w-full flex items-center justify-center -mt-12"><img src="./assets/logo.png" class="w-[170px]"></div>
            <div class="w-[90%] rounded-lg h-fit bg-fuchsia-100 bg-opacity-50 backdrop-blur p-8 py-12 border-2 border-fuchsia-400 drop-shadow-xl">
                <h1 class="font-semibold text-2xl">Consulta de horarios</h1>
                <form class="flex lg:flex-row flex-col min-w-fit justify-around items-end lg:space-y-0 space-y-2 w-full mt-8">
                    <div class="flex flex-col space-y-1">
                        <label for="origin" class="font-semibold">Origen</label>
                        <select name="origin" id="origin" placeholder="----" class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                            <option value="">Estacion 1</option>
                            <option value="">Estacion 2</option>
                            <option value="">Estacion 3</option>
                        </select>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="destiny">Destino</label>
                        <select name="destiny" id="destiny" placeholder="----" class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                            <option value="">Estacion 1</option>
                            <option value="">Estacion 2</option>
                            <option value="">Estacion 3</option>
                        </select>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="date">Fecha</label>
                        <input type="date" name="date" id="date" class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="time">Hora</label>
                        <select name="time" id="time" placeholder="----" class="w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
                            <option value="">13:00</option>
                            <option value="">14:00</option>
                            <option value="">15:00</option>
                        </select>
                    </div>
                    <button class="bg-fuchsia-100 hover:bg-fuchsia-900 hover:text-white text-fuchsia-900 border-2 font-semibold border-fuchsia-900 w-fit px-10 py-2 rounded-lg flex justify-between items-center text-xl">
                        Buscar
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>

                    </button>
                </form>
            </div>
            <div class="flex flex-row justify-center items-center w-[90%] h-fit md:mt-32 mt-4 md:space-x-24 space-x-4 mb-4">
                <a href="./routes.php" class="flex flex-col justify-center items-center hover:font-semibold hover:scale-105">
                    <div class="lg:w-[175px] lg:h-[175px] w-[100px] h-[100px] drop-shadow-xl bg-emerald-500 hover:bg-emerald-600 rounded-full flex justify-center items-center">
                        <img src="assets/train.svg" class="lg:h-[75px] h-[50px]" />
                    </div>
                    <div class="text-2xl mt-2 font-semibold">Líneas</div>
                </a>
                <a href="#" class="flex flex-col justify-center items-center hover:font-semibold hover:scale-105">
                    <div class="lg:w-[175px] lg:h-[175px] w-[100px] h-[100px] drop-shadow-xl bg-emerald-500 hover:bg-emerald-600 rounded-full flex justify-center items-center">
                        <img src="assets/time.svg" class="lg:h-[75px] h-[50px]" />
                    </div>
                    <div class="text-2xl mt-2 font-semibold">Horarios</div>
                </a>
                <a href="#" class="flex flex-col justify-center items-center hover:font-semibold hover:scale-105">
                    <div class="lg:w-[175px] lg:h-[175px] w-[100px] h-[100px] drop-shadow-xl bg-emerald-500 rounded-full hover:bg-emerald-600 flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="lg:h-[75px] h-[50px] stroke-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>

                    </div>
                    <div class="text-2xl mt-2 font-semibold">Estaciones</div>
                </a>
            </div>
        </div>

    </main>
</body>

</html>