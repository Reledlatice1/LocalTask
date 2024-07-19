<?php
print_r($_POST);
session_start();

if(isset($_POST['correo_electronico']) && isset($_POST['contraseña'])){
    require_once './conexion.php';
    $correo_electronico = $_POST['correo_electronico'];
    $contraseña = $_POST['contraseña'];
    $sql = "SELECT * FROM tb_usuarios WHERE correo_electronico = '$correo_electronico' AND contraseña = '$contraseña'";
    $result = $conexion->query($sql);
    if($result->num_rows > 0){ 
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id_usuario'];
        $_SESSION['correo_electronico'] = $row['correo_electronico'];
        $_SESSION['contraseña'] = $row['contraseña'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['ap_paterno'] = $row['ap_paterno'];
        $_SESSION['ap_materno'] = $row['ap_materno'];
        $_SESSION['telefono'] = $row['telefono'];
        $_SESSION['direccion'] = $row['direccion'];
        
        header("Location: ../views/home.html");
    }else{
        $_SESSION['error'] = "Contraseña incorrecta";
        header("Location: ../index.html");
    }
}else{
    $_SESSION['error'] = "Completa todos los campos";
    header("Location: ../index.html");
};

?>