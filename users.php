<?php
session_start();
session_get_cookie_params();
if (!isset($_SESSION['user'])) {
    header('Location: ./index.php');
}
$current_user = $_SESSION["user"];
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
            <div class="w-full text-center text-4xl font-bold h-52 flex justify-center items-center station-main text-white">
                Usuarios
            </div>
            <div class="flex flex-row justify-start items-center md:w-2/3 w-[90%]">
                <a href="./users/new.php" class="flex justify-between w-fit px-3 py-2 hover:bg-emerald-500 text-emerald-500 hover:text-white hover:stroke-white stroke-emerald-500 border border-2 border-emerald-500 rounded-lg font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mr-2 stroke-inherit">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Añadir Usuario
                </a>
            </div>
            <div class="flex flex-row justify-evenly items-center md:w-2/3 w-[90%] text-center text-xl font-semibold border-b border-b-black">
                <div class="w-2/5 text-left px-10 py-1">Nombre</div>
                <div class="w-2/5 py-1">Email</div>
                <div class="w-1/5"></div>
            </div>

            <?php
            include "api/users.php";

            use api\users;

            if ($_SESSION["user"] == "admin@tenfe.com") {
                $users = users::getUsers();
            } else {
                $users = users::getAll();
            }

            foreach ($users as $user) : ?>
                <div class="flex flex-row justify-evenly items-center md:w-2/3 w-[90%] text-center">
                    <div class="w-2/5 text-left px-10 py-1"><?= $user["name"] ?></div>
                    <div class="w-2/5 py-1"><?= $user["email"] ?></div>
                    <div class="w-1/5 flex flex-row items-center justify-around">
                        <a href="./users/edit.php?id=<?= $user["id"] ?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-emerald-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg></a>
                        <?php if ($user["email"] != $current_user) : ?>
                            <a href="./users/delete.php?id=<?= $user["id"] ?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg></a>
                        <?php else : ?>
                            <button id="user-delete" class="cursor-not-allowed"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg></button>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
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
                            case 'new':
                                echo "Usuario creado correctamente";
                                break;
                            case 'edit':
                                echo "Usuario editado correctamente";
                                break;
                            case 'delete':
                                echo "Usuario eliminado correctamente";
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
    <?php if (isset($_GET['error'])) : ?>
        <div class="toast fixed flex flex-col bottom-4 rounded-xl left-2 w-96 h-24 bg-red-600">
            <div class="h-4/5 flex flex-row justify-between items-center px-8 pt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span class="text-white font-semibold">Se ha producido un error</span>
            </div>
            <div class="h-1/5 rounded-b-xl">
                <div class="w-full h-full rounded-b-xl bg-red-800 loader"></div>
            </div>
        <?php endif; ?>
        <script>
            function userWarning() {
                alert("No puedes eliminar tu propio usuario");
            }
            const userDelete = document.getElementById("user-delete");
            if (userDelete) {
                userDelete.addEventListener("click", userWarning);
            }
        </script>
</body>

</html>