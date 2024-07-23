<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

include '../connection/conexion.php';

// Recuperar el id del usuario desde la sesión
$id_usuario = $_SESSION['id'];

// Consulta para obtener los servicios del usuario autenticado
$sql = "SELECT s.id_trabajo, s.nombre, s.descripcion, s.imagen, u.nombre as usuario 
        FROM tb_trabajos s 
        JOIN tb_usuarios u ON s.id_usuario = u.id_usuario 
        WHERE s.id_usuario = ? 
        ORDER BY s.id_trabajo DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="en">

<head>
    <title>LocalTask</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,400;1,700&family=Bitter:ital,wght@0,100..900;1,100..900&family=Changa:wght@200..800&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="stylesheet" href="../styles/TusServicios.css">

</head>

<body>
    <header>
        <!-- place navbar here -->
        <nav class="nav-header">
            <div class="logo">
                <img class="logo" src="../img/logo.png" width="60%">
            </div>

            <div class="menu-nav">
                <a href="./home.html" class="fs-5">Inicio</a>
                <a href="./servicios.php" class="fs-5">Servicios</a>
                <a href="./sobreNosotros.html" class="fs-5">Sobre nosotros</a>
            </div>

            <div class="boton-usuario">
                <a class="btn btn-light" href="./TusServicios.php">Mis servicios</a>
                <a class="btn btn-light" href="./infoServicios.php">Crear Servicio</a>
                <a href="./editarPerfil.php"><i class="bi bi-person-circle" style="font-size: 55px;"></i></a>
            </div>
        </nav>
    </header>
    <main>

        <h1 class="text-center p-3 fw-bold">Tus servicios</h1>

        <div class="tabla-servicios">

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre del servicio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_trabajo = $row['id_trabajo'];
                $nombre = $row['nombre'];
                $descripcion = $row['descripcion'];
                $imagen = "../functions/" . $row['imagen'];
                $usuario = $row['usuario'];
        ?>
                    <tr>
                        <td>
                            <img src="<?php echo $imagen; ?>" width="200px" height="10%">
                        </td>
                        <td><?php echo $nombre; ?></td>
                        <td>
                            <a href="../views/infoActualizar.php?id_trabajo=<?php echo $id_trabajo; ?>">
                                <button class="gestion" type="button">Actualizar</button></a>
                                <a href="../functions/borrar_trabajo.php?id_trabajo=<?php echo $id_trabajo; ?>">
                            <button class="eliminar">Eliminar</button></a>
                        </td>
                    </tr>
                    <?php
            }
        } else {
            echo "No hay servicios disponibles.";
        }
        $stmt->close();
        $conexion->close();
        ?>
                </tbody>
            </table>

        </div>

    </main>
    <footer>
        <div class="contenido-footer">
            <nav class="nav-footer">
                <a href="./views/Public/MapaSitio.html">Mapa de sitio</a>
                <a href="./views/Public/Avisos.html">Avisos de privacidad</a>
                <a href="./views/Public/Terminos.html">Terminos y condiciones</a>
            </nav>
            <p> Ricardo, Nadia, Marco, Francisco, Ramon <br> Todos los derechos reservados &copy;</p>
        </div>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>
