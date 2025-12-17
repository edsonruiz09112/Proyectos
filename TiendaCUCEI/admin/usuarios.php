<?php
require_once __DIR__ . '/../includes/header.php';

if (!is_logged_in() || $_SESSION['user_rol'] !== 'admin') {
    redirect('../index.php');
}

$stmt = $pdo->query("
    SELECT id, nombre, apellidos, correo, rol, eliminado
    FROM clientes
    ORDER BY id DESC
");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <h2 class="fw-bold text-primary mb-4">Gestión de Usuarios</h2>

    <table class="table table-striped text-center">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id']; ?></td>
                <td><?= e($u['nombre'] . ' ' . $u['apellidos']); ?></td>
                <td><?= e($u['correo']); ?></td>
                <td><?= e($u['rol']); ?></td>

                <td>
                    <?php if ($u['eliminado'] == 1): ?>
                        <span class="badge bg-danger">Baneado</span>
                    <?php else: ?>
                        <span class="badge bg-success">Activo</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($u['eliminado'] == 0): ?>
                        <a href="banear.php?id=<?= $u['id']; ?>" class="btn btn-sm btn-danger">Banear</a>
                    <?php else: ?>
                        <a href="desbanear.php?id=<?= $u['id']; ?>" class="btn btn-sm btn-success">Desbanear</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Volver</a>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
