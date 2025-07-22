<?php

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['login_error'] = "Debes iniciar sesión primero.";
    header("Location: ../reserva.php");
    exit;
}


include __DIR__ . '/../config/conexion.php';

$idUsuario = $_SESSION['id_usuario'];
$stmt = $conn->prepare("SELECT nombre, apellido, tipo FROM persona WHERE id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (strtolower(trim($usuario['tipo'])) !== 'admin') {
    $_SESSION['login_error'] = "Acceso denegado. Solo administradores.";
    header("Location: ../reserva.php");
    exit;
}

$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'id_reserva';

// Consulta SQL
$sql = "SELECT * FROM reserva";
if (!empty($buscar)) {
    $sql .= " WHERE $filtro LIKE :buscar";
}
$stmt = $conn->prepare($sql);
if (!empty($buscar)) {
    $stmt->bindValue(':buscar', "%$buscar%");
}
$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Paginación
$totalRegistros = count($reservas);
$porPagina = 10;
$paginaActual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$totalPaginas = ceil($totalRegistros / $porPagina);
if ($totalPaginas < 1) $totalPaginas = 1;
$inicio = ($paginaActual - 1) * $porPagina;
$reservas = array_slice($reservas, $inicio, $porPagina);
?>