<?php 
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$target_file = $target_dir . basename($_FILES["imagen"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verificar si es una imagen real
$check = getimagesize($_FILES["imagen"]["tmp_name"]);
if($check !== false) {
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);
    $imagen = $target_file;
} else {
    die("El archivo no es una imagen.");
}

include '../connection/conexion.php';

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$id_usuario = $_POST['id_usuario'];

$sql = "INSERT INTO tb_trabajos (nombre, descripcion, imagen, id_usuario) VALUES ('$nombre', '$descripcion', '$imagen', '$id_usuario')";

if ($conexion->query($sql) === TRUE) {
    echo "Nuevo servicio creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

header('Location: ../views/servicios.php');
$conexion->close();
?>

?>