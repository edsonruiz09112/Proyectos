<?php
require_once __DIR__ . '/includes/header.php';

if (!is_logged_in() || $_SESSION['user_rol'] !== 'comprador') {
    redirect('index.php');
}

$producto_id = $_GET['id'] ?? null;

if (!$producto_id) {
    redirect('index.php');
}
?>

<div class="container my-5">
    <h2 class="fw-bold text-danger mb-4">Reportar Producto</h2>

    <form action="procesar_reporte.php" method="POST">
        <input type="hidden" name="producto_id" value="<?= $producto_id ?>">

        <div class="mb-3">
            <label class="form-label">Motivo del reporte:</label>
            <textarea name="motivo" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-danger">Enviar reporte</button>
        <a href="producto_detalle.php?id=<?= $producto_id ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
