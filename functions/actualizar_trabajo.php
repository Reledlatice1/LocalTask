<?php
include '../connection/conexion.php';

$id_trabajo = $_POST['id_trabajo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$id_usuario = $_POST['id_usuario'];

// Directorio donde se guardarán las imágenes subidas
$target_dir = "./uploads/";

// Verificar si el directorio existe y tiene permisos de escritura
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // Crear el directorio si no existe
}

// Verificar si se ha subido una nueva imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar el tipo de archivo
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowed_types)) {
        // Mover el archivo subido al directorio de destino
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $imagen = "uploads/" . basename($_FILES["imagen"]["name"]); // Ruta relativa para almacenar en la base de datos
        } else {
            echo "Hubo un error al subir la imagen.";
            exit();
        }
    } else {
        echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        exit();
    }
} else {
    // Mantener la imagen actual si no se ha subido una nueva
    $imagen = $_POST['imagen_actual'];
}

$query = "UPDATE tb_trabajos SET nombre = ?, descripcion = ?, imagen = ? WHERE id_trabajo = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('sssi', $nombre, $descripcion, $imagen, $id_trabajo);

if ($stmt->execute()) {
    header('Location: ../views/TusServicios.php');
} else {
    echo "Error al actualizar el servicio: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
