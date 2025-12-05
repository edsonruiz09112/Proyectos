<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';
session_start();

if (!is_logged_in() || $_SESSION['user_rol'] !== 'comprador') {
    redirect('index.php');
}

$producto_id = $_POST['producto_id'] ?? null;
$motivo = $_POST['motivo'] ?? '';
$comprador_id = $_SESSION['user_id'];

if ($producto_id && $motivo) {
    $stmt = $pdo->prepare("
        INSERT INTO reportes (producto_id, comprador_id, motivo)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([$producto_id, $comprador_id, $motivo]);

    setMsg('success', 'Reporte enviado correctamente.');
}

redirect("producto_detalle.php?id=$producto_id");
exit;
