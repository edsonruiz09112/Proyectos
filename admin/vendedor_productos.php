<?php
require_once __DIR__ . '/../includes/header.php';

if (!is_logged_in() || $_SESSION['user_rol'] !== 'admin') {
    redirect('../index.php');
}

$id_vendedor = $_GET['id'] ?? null;

if (!$id_vendedor) {
    redirect('vendedores.php');
}

// Obtener datos del vendedor
$stmt = $pdo->prepare("
    SELECT nombre, apellidos 
    FROM clientes 
    WHERE id = ? AND rol = 'vendedor'
");
$stmt->execute([$id_vendedor]);
$vendedor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vendedor) {
    redirect('vendedores.php');
}

// Obtener productos del vendedor
$stmt = $pdo->prepare("
    SELECT id, nombre, precio, stock 
    FROM productos 
    WHERE vendedor_id = ? AND eliminado = 0
    ORDER BY id DESC
");
$stmt->execute([$id_vendedor]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <h2 class="fw-bold text-primary mb-3">
        Productos de <?= e($vendedor['nombre'] . ' ' . $vendedor['apellidos']); ?>
    </h2>

    <?php if (empty($productos)): ?>
        <p class="text-muted">Este vendedor no tiene productos publicados.</p>
    <?php else: ?>

    <table class="table table-striped text-center">
        <thead class="table-warning">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= $p['id']; ?></td>
                <td><?= e($p['nombre']); ?></td>
                <td>$<?= number_format($p['precio'], 2); ?></td>
                <td><?= $p['stock']; ?></td>

                <td>
                    <a href="ver_producto.php?id=<?= $p['id']; ?>&return=vendedor_productos.php?id=<?= $id_vendedor ?>"
                        class="btn btn-sm btn-info">
                        Ver detalle
                    </a>

                    <a href="eliminar_producto.php?id=<?= $p['id']; ?>&from=vendedor&id_v=<?= $id_vendedor ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar este producto?');">
                        Eliminar
                    </a>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>

    <a href="vendedores.php" class="btn btn-secondary mt-3">Volver a vendedores</a>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
