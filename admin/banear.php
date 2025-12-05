<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
session_start();

// Seguridad admin
if (!is_logged_in() || $_SESSION['user_rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("UPDATE clientes SET eliminado = 1 WHERE id = ?");
    $stmt->execute([$id]);
}

// REDIRECCIÓN CORRECTA SIN BASE_URL
header("Location: usuarios.php");
exit;
