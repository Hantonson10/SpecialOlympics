<?php session_start();

    // Vuelve a index despues de anular los datos de sesion
    unset($_SESSION['id']);
    header('Location: login.php');

?>