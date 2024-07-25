<?php
session_start();
include '../connection/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

$id_usuario = $_SESSION['id'];

// Verificar si el ID del comentario ha sido enviado
if (!isset($_POST['id_comentario'])) {
    echo "Comentario no encontrado.";
    exit();
}

$id_comentario = intval($_POST['id_comentario']);

// Eliminar el comentario de la base de datos
$sql = "DELETE FROM tb_comentarios WHERE id_comentario = ? AND id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('ii', $id_comentario, $id_usuario);
$stmt->execute();

header("Location: ../views/servicios.php");
exit();
?>
