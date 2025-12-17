<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

if (!is_logged_in() || $_SESSION['user_rol'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'] ?? null;
$return = $_GET['return'] ?? 'productos.php';

if ($id) {
    $stmt = $pdo->prepare("UPDATE productos SET eliminado = 0 WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: " . $return);
exit;
