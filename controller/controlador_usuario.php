<?php
include __DIR__ . '/../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['login_error'] = "Debes iniciar sesión primero.";
    header("Location: ../reserva.php");
    exit;
}

$idUsuario = $_SESSION['id_usuario'];
$sql = "SELECT nombre, apellido, tipo FROM persona WHERE id_usuario = :id_usuario";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (strtolower(trim($usuario['tipo'])) !== 'admin') {
    $_SESSION['login_error'] = "Acceso denegado. Solo administradores.";
    header("Location: ../reserva.php");
    exit;
}

$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$porPagina = 10;
$paginaActual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $porPagina;

// Contar total de registros
$sqlCount = "SELECT COUNT(*) as total FROM persona";
$params = [];

if (!empty($buscar)) {
    $sqlCount .= " WHERE nombre LIKE :buscar";
    $params[':buscar'] = "%$buscar%";
}

$stmtCount = $conn->prepare($sqlCount);
foreach ($params as $key => $val) {
    $stmtCount->bindValue($key, $val);
}
$stmtCount->execute();
$totalRegistros = (int)$stmtCount->fetchColumn();

$totalPaginas = ceil($totalRegistros / $porPagina);

// Consulta principal con LIMIT y OFFSET
$sql = "SELECT * FROM persona";
if (!empty($buscar)) {
    $sql .= " WHERE nombre LIKE :buscar";
}
$sql .= " ORDER BY id_usuario ASC LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
if (!empty($buscar)) {
    $stmt->bindValue(':buscar', "%$buscar%");
}
$stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$personas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>