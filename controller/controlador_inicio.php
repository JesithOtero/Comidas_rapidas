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

$totalClientes = 0;
$totalPedidos = 0;
$montoTotal = 0;

// Total de clientes
$sql = "SELECT COUNT(*) as total FROM persona WHERE tipo = 'usuario'";
if ($result = $conn->query($sql)) {
    $row = $result->fetch();
    $totalClientes = $row['total'];
}

// Total de pedidos (únicos)
$sql = "SELECT COUNT(DISTINCT id_pedido) as total FROM pedido";
if ($result = $conn->query($sql)) {
    $row = $result->fetch();
    $totalPedidos = $row['total'];
}

// Monto total
$sql = "SELECT SUM(p.cantidad * c.precio) AS total 
        FROM pedido p 
        JOIN comida c ON p.id_comida = c.id_comida";
if ($result = $conn->query($sql)) {
    $row = $result->fetch();
    $montoTotal = $row['total'] ?? 0;
}

// Últimos pedidos
$ultimosPedidos = [];
$sql = "SELECT 
            p.id_pedido AS id,
            r.fecha AS fecha,
            SUM(p.cantidad * c.precio) AS monto,
            u.nombre
        FROM pedido p
        JOIN comida c ON p.id_comida = c.id_comida
        JOIN reserva r ON p.id_reserva = r.id_reserva
        JOIN persona u ON r.id_usuario = u.id_usuario
        GROUP BY p.id_pedido, r.fecha, u.nombre
        ORDER BY r.fecha DESC
        LIMIT 5";

$result = $conn->query($sql);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $ultimosPedidos[] = $row;
}

// Monto total diario
$montoDiario = [];
$sql = "SELECT 
            r.fecha AS fecha,
            SUM(p.cantidad * c.precio) AS monto
        FROM pedido p
        JOIN comida c ON p.id_comida = c.id_comida
        JOIN reserva r ON p.id_reserva = r.id_reserva
        GROUP BY r.fecha
        ORDER BY r.fecha";
$result = $conn->query($sql);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $montoDiario[] = $row;
}


?>