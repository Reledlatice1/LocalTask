<?php
include '../connection/conexion.php';

// Obtener el ID del servicio desde la URL
if (!isset($_GET['id_trabajo'])) {
    echo "Servicio no encontrado.";
    exit();
}

$id_trabajo = intval($_GET['id_trabajo']);

// Consulta para obtener los detalles del servicio
$query = "SELECT * FROM tb_trabajos WHERE id_trabajo = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_trabajo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "Servicio no encontrado.";
    exit();
}

$service = $resultado->fetch_assoc();
$stmt->close();
$conexion->close();
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
    <link rel="stylesheet" href="../styles/infoServicios.css">

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
        <h1 class="text-center p-3">Mi servicio</h1>

        <section class="contenedor_formulario">
            <div class="service-form">
                <img src="../functions/" alt="">
                <form action="../functions/actualizar_trabajo.php" method="post" enctype="multipart/form-data">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($service['nombre']); ?>">
        
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($service['descripcion']); ?></textarea>
                    
                    <label for="imagen">Imagen</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
        
                    <input type="hidden" id="id_trabajo" name="id_trabajo" value="<?php echo $id_trabajo; ?>">
        
                    <button type="submit">Guardar</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <div class="contenido-footer">
            <nav class="nav-footer">
                <a href="/views/Public/MapaSitio.html">Mapa de sitio</a>
                <a href="/views/Public/Avisos.html">Avisos de privacidad</a>
                <a href="/views/Public/Terminos.html">Terminos y condiciones</a>
            </nav>
            <p> Ricardo, Nadia, Marco, Fransico, Ramon <br> Todos los derechos reservados &copy;</p>
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
