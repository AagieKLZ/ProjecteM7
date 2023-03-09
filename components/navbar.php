<nav class="fixed lg:w-full left-0 w-full h-14 border-b border-b-black bg-transparent backdrop-blur z-50 top-0 left-0 flex flex-row justify-around items-center">
    <a href="index.php" class="block h-14 my-auto"><img src="assets/logo.png" alt="logo" class="h-14 my-auto"></a>
    <div class="lg:flex hidden justify-end space-x-16 items-center">
        <a href="./routes.php" class="hover:underline text-lg text-fuchsia-900">Líneas</a>
        <a href="#" class="hover:underline text-lg text-fuchsia-900">Horarios</a>
        <a href="./stations.php" class="hover:underline text-lg text-fuchsia-900">Estaciones</a>
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
    <?php include 'components/modalButton.php'; ?>

</nav>