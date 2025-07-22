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

// Consulta con JOIN para obtener nombre y precio de la comida
$sql = "SELECT p.*, c.nombre AS nombre_comida, c.precio 
        FROM pedido p
        JOIN comida c ON p.id_comida = c.id_comida";

if (!empty($buscar)) {
    $sql .= " WHERE p.id_reserva LIKE :buscar";
}

$sql .= " ORDER BY p.id_pedido ASC";

$stmt = $conn->prepare($sql);

if (!empty($buscar)) {
    $stmt->bindValue(':buscar', "%$buscar%");
}

$stmt->execute();
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Paginación
$totalRegistros = count($pedidos);
$porPagina = 10;
$paginaActual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$totalPaginas = ceil($totalRegistros / $porPagina);
if ($totalPaginas < 1) $totalPaginas = 1;
$inicio = ($paginaActual - 1) * $porPagina;
$pedidos = array_slice($pedidos, $inicio, $porPagina);
?>
