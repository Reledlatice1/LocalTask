<?php
session_start();
include '../connection/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

$id_usuario = $_SESSION['id'];

// Verificar si los datos del formulario han sido enviados
if (!isset($_POST['comentario']) || !isset($_POST['id_comentario'])) {
    echo "Datos incompletos.";
    exit();
}

$id_comentario = intval($_POST['id_comentario']);
$comentario = $_POST['comentario'];

// Actualizar el comentario en la base de datos
$sql = "UPDATE tb_comentarios SET comentario = ? WHERE id_comentario = ? AND id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('sii', $comentario, $id_comentario, $id_usuario);
$stmt->execute();

header("Location: ../views/servicios.php");
exit();
?>
