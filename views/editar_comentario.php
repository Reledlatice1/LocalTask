<?php
session_start();
include '../connection/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    header("Location: ../index.html");
    exit();
}

$id_usuario = $_SESSION['id'];

// Obtener el ID del comentario desde la URL
if (!isset($_GET['id_comentario'])) {
    echo "Comentario no encontrado.";
    exit();
}

$id_comentario = intval($_GET['id_comentario']);

// Consultar el comentario para asegurarse de que pertenece al usuario
$sql = "SELECT comentario FROM tb_comentarios WHERE id_comentario = ? AND id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('ii', $id_comentario, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Comentario no encontrado o no tiene permiso para editarlo.";
    exit();
}

$comment = $result->fetch_assoc();
$stmt->close();
$conexion->close();
?>

<!doctype html>
<html lang="en">
<head>
    <title>Editar Comentario</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<main>
    <section>
        <h3>Editar Comentario</h3>
        <form action="../functions/actualizar_comentario.php" method="post">
            <textarea name="comentario" required><?php echo htmlspecialchars($comment['comentario']); ?></textarea>
            <input type="hidden" name="id_comentario" value="<?php echo $id_comentario; ?>">
            <button type="submit">Actualizar</button>
        </form>
    </section>
</main>
</body>
</html>
