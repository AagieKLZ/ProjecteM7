<nav class="fixed lg:w-full left-0 w-full h-14 bg-gray-200 bg-opacity-50 backdrop-blur z-40 top-0 left-0 flex flex-row lg:justify-around justify-between items-center">
    <a href="index.php" class="block h-14 my-auto"><img src="assets/logo.png" alt="logo" class="h-14 my-auto"></a>
    <div class="lg:flex hidden justify-end space-x-16 items-center">
        <a id="lineas" href="./routes.php" class="text-xl text-fuchsia-900 menu-item">Líneas</a>
        <a id="horarios" href="./schedule.php" class="text-xl text-fuchsia-900 menu-item">Horarios</a>
        <a id="estaciones" href="./stations.php" class="text-xl text-fuchsia-900 menu-item">Estaciones</a>
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
    <script>
        const path = window.location.pathname.split("/")[2]
        let link;
        if (path == "routes.php"){
            link = document.getElementById("lineas")
        } else if (path == "stations.php"){
            link = document.getElementById("estaciones")
        } else if (path == "schedule.php"){
            link = document.getElementById("horarios")
        }
        if (link){
            link.classList.add("font-semibold")
        }
        
    </script>
</nav>