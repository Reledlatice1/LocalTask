<?php
print_r($_GET);
include '../connection/conexion.php';

$id_trabajo = $_GET['id_trabajo'];
$query = "DELETE FROM tb_trabajos WHERE id_trabajo = '$id_trabajo'";

$delete = $conexion->query($query);

header('Location: ../views/TusServicios.php')

?>