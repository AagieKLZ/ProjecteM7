<nav class="fixed lg:w-full left-0 w-full h-14 bg-gray-200 bg-opacity-50 backdrop-blur z-40 top-0 left-0 flex flex-row lg:justify-around justify-between items-center">
    <a href="index.php" class="block h-14 my-auto"><img src="assets/logo.png" alt="logo" class="h-14 my-auto"></a>
    <div class="lg:flex hidden justify-end space-x-16 items-center">
        <a href="./routes.php" class="text-xl text-fuchsia-900 menu-item">Líneas</a>
        <a href="#" class="text-xl text-fuchsia-900 menu-item">Horarios</a>
        <a href="./stations.php" class="text-xl text-fuchsia-900 menu-item">Estaciones</a>
    </div>
    <!-- <?php include "components/loginButton.php"; ?> -->
    <?php 
        if (isset($_SESSION["user"])){
            include "components/adminButton.php";
        } else {
            include "components/loginButton.php";
        }
    ?>
    <input type="checkbox" name="dropdown" id="menu-dropdown" class="hidden">
    <?php 
        include 'components/modalButton.php';
        include 'components/sideModal.php';
    ?>

</nav>