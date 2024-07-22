<?php 
session_start();


if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
}


include '../connection/conexion.php';
$id_usuario = $_SESSION['id'];
$nombre = $_SESSION['nombre'];
$correo_electronico = $_SESSION['correo_electronico'];
$telefono = $_SESSION['telefono'];
$direccion = $_SESSION['direccion'];



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
    <link rel="stylesheet" href="../styles/editarPerfil.css">
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
    <main class="flex-grow-1">
        <section class="contenedor-card">
            <div class="background-card">
                <h1 class="text-center fw-bold p-3">Editar Perfil</h1>
                <p class="text-center fs-5">Datos personales</p>
                <form class="contenedor-editar">
                    <div class="bloque-editar-1">
                        <input class="form-control" type="text" placeholder="Nombre" value="<?= $nombre ?>">
                        <input class="form-control" type="email" placeholder="Correo Electronico" value="<?= $correo_electronico ?>">
                    </div>
                    <div class="bloque-editar-2">
                        <input class="form-control" type="tel" placeholder="Telefono" value="<?= $telefono?>">
                        <input class="form-control" type="text" placeholder="Direccion" value="<?= $direccion ?>">
                    </div>

                    <div class="centro-boton">
                        <button class="guardar btn">Guardar</button>
                    </div>
                </form>

                <p class="text-center fs-5 p-3">Tus redes sociales</p>
                <form>
                    <div class="redes-editar">
                        <input placeholder="Facebook" class="form-control">
                        <input placeholder="Telegram" class="form-control">
                        <input placeholder="Instagram" class="form-control">
                    </div>

                    <div class="centro-boton">
                        <button class="guardar btn">Guardar</button>
                    </div>
                </form>

                <p class="text-center fs-5 p-3">Actualizar Contraseña</p>
                <form>
                    <div class="contenedor-contraseña">
                        <input placeholder="Contraseña Anterior" class="form-control">
                        <input placeholder="Contraseña Nueva" class="form-control">
                    </div>

                    <div class="centro-boton">
                        <button class="guardar btn">Guardar</button>
                    </div>
                </form>

                <p class="text-center fs-5 p-3">Acciones</p>
                <div class="centro-cerrar">
                    <a href="../connection/logout.php">
                        <button type="button" class="btn btn-danger">Cerrar Sesion</button>
                    </a>
                </div>
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