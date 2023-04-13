<nav class="fixed lg:w-full left-0 w-full h-14 bg-gray-200 bg-opacity-50 backdrop-blur z-40 top-0 left-0 flex flex-row lg:justify-around justify-between items-center">
        <a href="../index.php" class="block h-14 my-auto"><img src="../assets/logo.png" alt="logo" class="h-14 my-auto"></a>
        <div class="lg:flex hidden justify-end space-x-16 items-center">
            <a href="../routes.php" class="text-xl text-fuchsia-900 menu-item">Líneas</a>
            <a href="../schedule.php" class="text-xl text-fuchsia-900 menu-item">Horarios</a>
            <a href="../stations.php" class="text-xl text-fuchsia-900 menu-item">Estaciones</a>
        </div>
        <?php
        if (isset($_SESSION["user"])) {
            include "../components/altAdminButton.php";
        } else {
            echo '
            <a href="login.php" class="btn lg:flex hidden py-2 px-3 font-semibold hover:bg-fuchsia-900 rounded-lg text-fuchsia-900 flex items-center border border-fuchsia-900">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 fill-fuchsia-900 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span>Iniciar Sesión</span>
        </a>
            ';
        }
        ?>
        <input type="checkbox" name="dropdown" id="menu-dropdown" class="hidden">
        <?php
            include '../components/modalButton.php';
            include '../components/altSideModal.php';
        ?>

    </nav>