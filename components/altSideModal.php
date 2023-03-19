<div class="modal fixed hidden left-0 top-0 w-full h-screen bg-transparent z-30 mr-0">
    
</div>
<div class="modal-menu sm:w-1/2 w-[90%] absolute top-0 right-0 z-30 h-screen bg-gray-200 flex flex-col justify-start items-end space-y-12 pt-24 px-4">
        <a href="../routes.php" class="text-xl text-fuchsia-900 menu-item">Líneas</a>
        <a href="../schedule.php" class="text-xl text-fuchsia-900 menu-item">Horarios</a>
        <a href="../stations.php" class="text-xl text-fuchsia-900 menu-item">Estaciones</a>
        <?php
            if (!isset($_SESSION["user"])):
        ?>
                <a href="../login.php" class="text-xl text-fuchsia-900 block hover:bg-fuchsia-900 hover:text-white px-4 py-2 mt-24 rounded-lg border-2 font-semibold border-fuchsia-900">Iniciar sesión</a>
        <?php else: ?>
                <a href="../lib/logout.php" class="text-xl text-red-600 hover:bg-red-500 hover:text-white block px-4 py-2 mt-24 rounded-lg border-2 font-semibold border-red-500">Cerrar sesión</a> 
                <a href="../admin.php" class="text-xl text-fuchsia-900 block hover:bg-fuchsia-900 hover:text-white px-4 py-2 mt-24 rounded-lg border-2 font-semibold border-fuchsia-900">Panel de Administración</a>
                
        <?php endif; ?>
    </div>