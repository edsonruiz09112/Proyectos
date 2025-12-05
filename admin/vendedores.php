<?php
require_once __DIR__ . '/../includes/header.php';

if (!is_logged_in() || $_SESSION['user_rol'] !== 'admin') {
    redirect('../index.php');
}

$stmt = $pdo->query("
    SELECT id, nombre, apellidos, correo 
    FROM clientes 
    WHERE rol = 'vendedor'
");

$vendedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <h2 class="fw-bold text-primary mb-4">Vendedores Registrados</h2>

    <table class="table table-striped text-center">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($vendedores as $v): ?>
            <tr>
                <td><?= $v['id']; ?></td>
                <td><?= e($v['nombre'] . ' ' . $v['apellidos']); ?></td>
                <td><?= e($v['correo']); ?></td>

                <td>
                    <a href="vendedor_productos.php?id=<?= $v['id']; ?>" 
                       class="btn btn-sm btn-primary">
                       Ver productos
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Volver</a>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
