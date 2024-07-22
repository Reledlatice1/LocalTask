<?php 
include '../connection/conexion.php';
print_r($_GET);
// Obtener el término de búsqueda si está presente
$search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';

// Consulta para obtener todos los servicios o filtrar por término de búsqueda
if (!empty($search)) {
    $sql = "SELECT s.id_trabajo, s.nombre, s.descripcion, s.imagen, u.nombre as usuario 
            FROM tb_trabajos s 
            JOIN tb_usuarios u ON s.id_usuario = u.id_usuario 
            WHERE s.nombre LIKE '%$search%' 
            ORDER BY s.id_trabajo DESC";
} else {
    $sql = "SELECT s.id_trabajo, s.nombre, s.descripcion, s.imagen, u.nombre as usuario 
            FROM tb_trabajos s 
            JOIN tb_usuarios u ON s.id_usuario = u.id_usuario 
            ORDER BY s.id_trabajo DESC";
}
$result = $conexion->query($sql);


header('Location: ../views/serviciosResultados.php');
?>
