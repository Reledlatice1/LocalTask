<?php
session_start();
include '../connection/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

$id_usuario = $_SESSION['id'];

// Obtener el ID del servicio desde la URL
if (!isset($_GET['id_trabajo'])) {
    echo "Servicio no encontrado.";
    exit();
}

$id_trabajo = intval($_GET['id_trabajo']);

// Consulta para obtener los detalles del servicio
$sql = "SELECT s.nombre, s.descripcion, s.imagen, u.nombre as usuario 
        FROM tb_trabajos s 
        JOIN tb_usuarios u ON s.id_usuario = u.id_usuario 
        WHERE s.id_trabajo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_trabajo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Servicio no encontrado.";
    exit();
}

$service = $result->fetch_assoc();
$stmt->close();

// Consulta para obtener los comentarios del servicio
$comment_sql = "SELECT c.id_comentario, c.comentario, u.nombre as usuario, c.id_usuario 
                FROM tb_comentarios c 
                JOIN tb_usuarios u ON c.id_usuario = u.id_usuario 
                WHERE c.id_trabajo = ?";
$comment_stmt = $conexion->prepare($comment_sql);
$comment_stmt->bind_param('i', $id_trabajo);
$comment_stmt->execute();
$comments = $comment_stmt->get_result();

$conexion->close();
?>
<!doctype html>
<html lang="en">
<head>
    <title>LocalTask</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,400;1,700&family=Bitter:ital,wght@0,100..900;1,100..900&family=Changa:wght@200..800&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="stylesheet" href="../styles/detallesServicios.css">
    <link rel="stylesheet" href="../styles/starRating.css">
</head>

<body>
<header>
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
    <section>
        <div class="contenedor-filas-1">
            <img src="../functions/<?php echo $service['imagen']; ?>" class="card-img-top" alt="..." style="width: 30%;">
            <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
            <p><?php echo htmlspecialchars($service['usuario']); ?></p>
        </div>
        <div class="contenedor-parrafo">
            <h3><?php echo htmlspecialchars($service['nombre']); ?></h3>
            <p><?php echo htmlspecialchars($service['descripcion']); ?></p>
        </div>
        <div class="botones">
            <!-- <button class="solicitar">Solicitar</button> -->
        </div>
        <div class="calificacion">
            <h3 style="font-size: 2rem;">Deja comentarios del servicio</h3>
            <div class="comentarios">
                <form action="../functions/guardar_cometario.php" method="post">
                    <textarea name="comentario" required></textarea>
                    <input type="hidden" name="id_trabajo" value="<?php echo $id_trabajo; ?>">
                    <div class="boton-enviar">
                        <button type="submit">Enviar</button>
                    </div>
                </form>
            </div>
            <div class="Opiniones">
                <h4 style="font-size: 2rem;">Opiniones del servicio</h4>
                <?php if ($comments->num_rows > 0): ?>
                    <?php while($comment = $comments->fetch_assoc()): ?>
                        <div class="opinion">
                            <strong><?php echo htmlspecialchars($comment['usuario']); ?>:</strong>
                            <p><?php echo htmlspecialchars($comment['comentario']); ?></p>
                            <?php if ($comment['id_usuario'] == $_SESSION['id']): ?>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCommentModal" 
                                        data-id_comentario="<?php echo $comment['id_comentario']; ?>" 
                                        data-comentario="<?php echo htmlspecialchars($comment['comentario']); ?>">
                                    Editar
                                </button>
                                <form action="../functions/eliminar_comentario.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id_comentario" value="<?php echo $comment['id_comentario']; ?>">
                                    <input type="hidden" name="id_trabajo" value="<?php echo $id_trabajo; ?>">
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('¿Seguro que quieres eliminar este comentario?')">Eliminar</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No hay comentarios aún.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<!-- Modal de Edición de Comentarios -->
<div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content comentarios">
            <form action="../functions/actualizar_comentario.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCommentModalLabel">Editar Comentario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea class="" name="comentario" id="editCommentText" required></textarea>
                    <input type="hidden" name="id_comentario" id="editCommentId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    <div class="contenido-footer">
        <nav class="nav-footer">
            <a href="/views/Public/MapaSitio.html">Mapa de sitio</a>
            <a href="/views/Public/Avisos.html">Avisos de privacidad</a>
            <a href="/views/Public/Terminos.html">Terminos y condiciones</a>
        </nav>
        <p> Ricardo, Nadia, Marco, Francisco, Ramon <br> Todos los derechos reservados &copy;</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script>
    var editCommentModal = document.getElementById('editCommentModal');
    editCommentModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var comment = button.getAttribute('data-comentario');
        var id_comentario = button.getAttribute('data-id_comentario');

        var modalTitle = editCommentModal.querySelector('.modal-title');
        var modalBodyInput = editCommentModal.querySelector('.modal-body textarea');

        modalBodyInput.value = comment;
        document.getElementById('editCommentId').value = id_comentario;
    });
</script>
</body>
</html>
