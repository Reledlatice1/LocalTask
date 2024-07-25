<?php

include '../connection/conexion.php';

//print_r($_POST);

$nombre = $_POST['nombre'];
$ap_paterno = $_POST['ap_paterno'];
$ap_materno = $_POST['ap_materno'];
$correo_electronico = $_POST['correo_electronico'];
$telefono = $_POST['telefono'];
$contraseña = $_POST['contraseña'];
$direccion = $_POST['direccion'];


$query = "INSERT INTO tb_usuarios (nombre, ap_paterno, ap_materno, correo_electronico, telefono, contraseña, direccion )
        VALUES ('$nombre', '$ap_paterno', '$ap_materno', '$correo_electronico', '$telefono', '$contraseña', '$direccion')";

$insert = $conexion->query($query);

header('Location: ../views/inicio.html');
?>