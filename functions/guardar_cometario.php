<?php
include '../connection/conexion.php';

session_start(); // Asegúrate de que los usuarios estén logueados y que su ID esté disponible

if (!isset($_SESSION['id'])) {
    echo "No estás logueado.";
    exit();
}

$id_usuario = $_SESSION['id'];
$id_trabajo = intval($_POST['id_trabajo']);
$comentario = $_POST['comentario'];

// Consulta para insertar el comentario
$sql = "INSERT INTO tb_comentarios (comentario, id_usuario, id_trabajo) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('sii', $comentario, $id_usuario, $id_trabajo);

if ($stmt->execute()) {
    header("Location: detallesServicio.php?id_trabajo=$id_trabajo");
} else {
    echo "Hubo un error al guardar el comentario.";
}

header("Location: ../views/servicios.php");
$stmt->close();
$conexion->close();
?>
