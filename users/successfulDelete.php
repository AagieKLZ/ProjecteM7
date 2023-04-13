<?php
include '../api/users.php';
use api\users;
session_start();
session_get_cookie_params();
if (!isset($_SESSION['user'])) { header('Location: ../index.php'); }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenfe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles.css">


</head>

<?php
if (!isset($_POST['id'])) {
    header('Location: ../users.php');
} else {
    users::delete($_POST['id']);
}

?>

<body class="mt-5">
<?php include '../components/altNavbar.php' ?>
<main class="flex flex-col justify-center items-center w-full h-[calc(100%-3.5rem)] mt-[3.5rem]">
    <div class="text-4xl mt-8 font-semibold">Eliminar Usuario</div>
    <div class="mt-32 text-lg">Usuario borrado</div>
    <form class="lg-w-2/12 mt-4 flex justify-between" action="../users.php">
        <input type="submit" class="px-3 text-lg cursor-pointer py-2 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-600" value="Volver" />
    </form>
</main>
</body>
</html>