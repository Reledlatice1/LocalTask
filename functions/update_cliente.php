<?php
session_start();

include '../connection/conexion.php';

$id_usuario = $_SESSION['id'];

// Actualizar datos personales
if (isset($_POST['nombre']) && isset($_POST['correo_electronico']) && isset($_POST['telefono']) && isset($_POST['direccion'])) {
    $nombre = $_POST['nombre'];
    $correo_electronico = $_POST['correo_electronico'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "UPDATE tb_usuarios SET nombre=?, correo_electronico=?, telefono=?, direccion=? WHERE id_usuario=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $correo_electronico, $telefono, $direccion, $id_usuario);
    $stmt->execute();

    $_SESSION['nombre'] = $nombre;
    $_SESSION['correo_electronico'] = $correo_electronico;
    $_SESSION['telefono'] = $telefono;
    $_SESSION['direccion'] = $direccion;

    header("Location: ../views/editarPerfil.php");
    exit();
}

// Actualizar contraseña
if (isset($_POST['contraseña_anterior']) && isset($_POST['contraseña_nueva'])) {
    $contraseña_anterior = $_POST['contraseña_anterior'];
    $contraseña_nueva = $_POST['contraseña_nueva'];

    $sql = "SELECT contraseña FROM usuarios WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($contraseña_anterior, $hashed_password)) {
        $nueva_contraseña_hashed = password_hash($contraseña_nueva, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET contraseña=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nueva_contraseña_hashed, $id_usuario);
        $stmt->execute();

        header("Location: ../views/editarPerfil.php");
        exit();
    } else {
        echo "Contraseña anterior incorrecta";
    }
}
?>
