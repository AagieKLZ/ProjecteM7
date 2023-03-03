<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenfe</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">

</head>

<body>

    <?php include 'components/navbar.php'; ?>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
        <form class="d-flex flex-column" style="margin-bottom: 8rem" action="lib/login.php" method="post">
            <h2 class="text-primary">Acceso para administradores</h2>
            <div class="mb-3 my-5">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="username" class="form-control" id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="pw" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" id="pw">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>


</body>

</html>