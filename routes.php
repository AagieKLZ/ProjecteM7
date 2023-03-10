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

<body class="mt-5">

    <?php include 'components/navbar.php'; ?>
    <main class="flex flex-row justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[3.5rem]">
        <div class="flex flex-col items-center w-full space-y-8 w-2/3 pb-4">
        <div class="w-full text-center text-4xl font-bold h-36 flex justify-center items-center line-main text-white">Líneas</div>
            <div class="flex flex-row justify-evenly items-center md:w-2/3 w-[90%] text-center text-xl font-semibold border-b border-b-black">
                <div>Linea</div>
                <div>Origen</div>
                <div>Destino</div>
            </div>
            <?php
            $lanes = ["R12", "R13", "R14","R12", "R13", "R14","R12", "R13", "R14","R12", "R13", "R14"];
            foreach ($lanes as $index => $lane) {
                if ($index % 2 == 1){
                    echo '
                    <div class="flex flex-row justify-evenly items-center md:w-2/3 w-[90%]">
                        <div class="bg-fuchsia-800 text-white w-[50px] h-[50px] flex items-center justify-center">
                            ' . $lane . '
                        </div>
                        <div>Placeholder</div>
                        <div>Placeholder</div>
                    </div>
                    ';
                } else {
                    echo '
                    <div class="flex flex-row justify-evenly items-center md:w-2/3 w-[90%] bg-gray-100 py-2">
                        <div class="bg-fuchsia-800 text-white w-[50px] h-[50px] flex items-center justify-center">
                            ' . $lane . '
                        </div>
                        <div>Placeholder</div>
                        <div>Placeholder</div>
                    </div>
                    ';
                }
            }
            ?>
        </div>


    </main>
</body>