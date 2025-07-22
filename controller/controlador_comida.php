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

// Consulta SQL para la tabla comida
$sql = "SELECT * FROM comida";
if (!empty($buscar)) {
    $sql .= " WHERE nombre LIKE :buscar";
}
$stmt = $conn->prepare($sql);
if (!empty($buscar)) {
    $stmt->bindValue(':buscar', "%$buscar%");
}
$stmt->execute();
$comidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Paginación
$totalRegistros = count($comidas);
$porPagina = 10;
$paginaActual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$totalPaginas = ceil($totalRegistros / $porPagina);
if ($totalPaginas < 1) {
    $totalPaginas = 1;  // Siempre mostrar paginación
}
$inicio = ($paginaActual - 1) * $porPagina;
$comidas = array_slice($comidas, $inicio, $porPagina);
?>