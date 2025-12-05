<?php
require_once __DIR__ . '/../includes/header.php';

if (!is_logged_in() || $_SESSION['user_rol'] !== 'admin') {
    redirect('../index.php');
}

// Obtener reportes
$stmt = $pdo->query("
    SELECT 
        r.id,
        r.motivo,
        r.estado,
        r.fecha,
        p.id AS producto_id,
        p.nombre AS producto_nombre,
        c.nombre AS comprador_nombre,
        c.apellidos AS comprador_apellidos,
        v.nombre AS vendedor_nombre,
        v.apellidos AS vendedor_apellidos,
        v.id AS vendedor_id
    FROM reportes r
    JOIN productos p ON r.producto_id = p.id
    JOIN clientes c ON r.comprador_id = c.id
    JOIN clientes v ON p.vendedor_id = v.id
    ORDER BY r.fecha DESC
");

$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <h2 class="fw-bold text-primary mb-4">Reportes de Productos</h2>

    <table class="table table-hover table-striped shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Vendedor</th>
                <th>Reportado por</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($reportes as $r): ?>
            <tr>
                <td><?= $r['id']; ?></td>

                <td><?= e($r['producto_nombre']); ?></td>

                <td><?= e($r['vendedor_nombre']) . ' ' . e($r['vendedor_apellidos']); ?></td>

                <td><?= e($r['comprador_nombre']) . ' ' . e($r['comprador_apellidos']); ?></td>

                <td><?= e($r['motivo']); ?></td>

                <td>
                    <?php if ($r['estado'] === 'pendiente'): ?>
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    <?php else: ?>
                        <span class="badge bg-success">Revisado</span>
                    <?php endif; ?>
                </td>

                <td><?= $r['fecha']; ?></td>

                <td>
                    <div class="d-flex flex-column gap-2">

                        <!-- Ver producto -->
                        <a href="ver_producto.php?id=<?= $r['producto_id']; ?>&return=admin/reportes.php"
                        class="btn btn-info btn-sm">
                        Ver producto
                        </a>

                        <!-- Marcar como revisado -->
                        <?php if ($r['estado'] === 'pendiente'): ?>
                            <a href="resolver_reporte.php?id=<?= $r['id']; ?>"
                            class="btn btn-success btn-sm">
                            Marcar como revisado
                            </a>
                        <?php endif; ?>

                        <!-- Eliminar producto -->
                        <a href="eliminar_producto.php?id=<?= $r['producto_id']; ?>&from=reportes&id_v=<?= $r['vendedor_id']; ?>&return=admin/reportes.php"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar este producto?');">
                        Eliminar producto
                        </a>

                        <!-- Eliminar reporte -->
                        <a href="eliminar_reporte.php?id=<?= $r['id']; ?>"
                        class="btn btn-secondary btn-sm"
                        onclick="return confirm('¿Eliminar este reporte?');">
                        Eliminar reporte
                        </a>

                    </div>
                </td>


            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Volver al Panel</a>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
