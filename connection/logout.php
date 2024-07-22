<?php
session_start();

require_once './conexion.php';

if(isset($_SESSION['id'])){
    session_destroy();
}

header("Location: ../index.html");
?>