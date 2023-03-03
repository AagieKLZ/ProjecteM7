<nav class="navbar navbar-expand-lg bg-primary-subtle ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img alt="tenfe" src="assets/logo.png" style="height: 65px"></img>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex-lg justify-content-end container-fluid" id="navbarNav">
            <ul class="navbar-nav row gx-5">
                <li class="nav-item col">
                    <a class="nav-link text-center fw-bold px-5 underline-on-hover" href="#">Rutas</a>
                </li>
                <li class="nav-item col">
                    <a class="nav-link text-center fw-bold px-5 underline-on-hover" href="#">Horarios</a>
                </li>
                <li class="nav-item col">
                    <a class="nav-link text-center fw-bold px-5 underline-on-hover" href="#">Viajeros</a>
                </li>
                <?php 
                if (isset($_SESSION['user'])) {
                    echo '<li class="nav-item col lg-span-4">
                    <a href="login.php" class="btn btn-success btn-sm text-center px-5 mt-1 text-nowrap fw-bold">Cerrar Sesión</a>
                </li>';
                } else {
                    echo '<li class="nav-item col lg-span-4">
                    <a href="login.php" class="btn btn-success btn-sm text-center px-5 mt-1 text-nowrap fw-bold">Iniciar Sesión</a></li>';
                }
                ?>
            </ul>

        </div>
    </div>
</nav>