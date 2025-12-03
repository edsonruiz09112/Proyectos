<?php
// vendedor/mis_preguntas.php

// 1. CARGAR DEPENDENCIAS MANUALMENTE (Sin HTML)
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

// 2. SEGURIDAD
if (!is_logged_in() || $_SESSION['user_rol'] !== 'vendedor') {
    redirect('index.php');
}

// 3. LÓGICA DE RESPONDER (Antes del Header)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pregunta_id'])) {
    $preg_id = (int)$_POST['pregunta_id'];
    $respuesta = trim($_POST['respuesta']);
    
    if (!empty($respuesta)) {
        $stmt = $pdo->prepare("UPDATE preguntas SET respuesta = :resp WHERE id = :pid");
        $stmt->execute(['resp' => $respuesta, 'pid' => $preg_id]);
        
        setMsg('success', 'Respuesta enviada.');
        // Ahora la redirección funcionará correctamente
        redirect('vendedor/mis_preguntas.php');
    }
}

// 4. CONSULTA DE PREGUNTAS (Antes del Header)
$sql = "SELECT preg.id as preg_id, preg.pregunta, preg.fecha, 
               prod.nombre as producto, prod.id as prod_id, prod.archivo,
               cli.nombre as cliente
        FROM preguntas preg
        JOIN productos prod ON preg.producto_id = prod.id
        JOIN clientes cli ON preg.usuario_id = cli.id
        WHERE prod.vendedor_id = :vid AND preg.respuesta IS NULL
        ORDER BY preg.fecha ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['vid' => $_SESSION['user_id']]);
$preguntas = $stmt->fetchAll();

// 5. AHORA SÍ: CARGAR LA VISTA
require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary">💬 Preguntas Pendientes</h2>
    <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill btn-sm">Volver al Panel</a>
</div>

<?php if (empty($preguntas)): ?>
    <div class="text-center p-5 bg-white rounded-4 shadow-sm">
        <div class="mb-3 opacity-25">
            <i class="fas fa-check-circle fa-4x text-success"></i>
        </div>
        <h4 class="text-muted fw-bold">¡Todo al día!</h4>
        <p class="text-muted mb-0">No tienes preguntas sin responder.</p>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($preguntas as $row): 
            $img = $row['archivo'] ? "../uploads/productos/".$row['archivo'] : "https://via.placeholder.com/80";
            if(!file_exists(__DIR__ . "/../uploads/productos/" . $row['archivo'])) $img = "https://via.placeholder.com/80?text=Sin+Foto";
        ?>
        <div class="col-md-6 col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex gap-3 align-items-start">
                    <img src="<?php echo $img; ?>" class="rounded-3 border" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="fw-bold text-primary mb-1">
                            <a href="../producto_detalle.php?id=<?php echo $row['prod_id']; ?>" target="_blank" class="text-decoration-none">
                                <?php echo e($row['producto']); ?> <i class="fas fa-external-link-alt small ms-1"></i>
                            </a>
                        </h6>
                        
                        <div class="bg-light p-3 rounded-3 mb-3 position-relative mt-2">
                            <span class="badge bg-secondary position-absolute top-0 start-0 translate-middle ms-3 mt-1 shadow-sm">
                                <?php echo e($row['cliente']); ?> preguntó:
                            </span>
                            <p class="mb-0 mt-2 text-dark fst-italic">"<?php echo e($row['pregunta']); ?>"</p>
                            <small class="text-muted d-block text-end mt-1" style="font-size: 0.75rem;">
                                <?php echo date("d/m/Y H:i", strtotime($row['fecha'])); ?>
                            </small>
                        </div>
                        
                        <form method="POST" class="d-flex gap-2">
                            <input type="hidden" name="pregunta_id" value="<?php echo $row['preg_id']; ?>">
                            <input type="text" name="respuesta" class="form-control rounded-pill" placeholder="Escribe tu respuesta aquí..." required>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>