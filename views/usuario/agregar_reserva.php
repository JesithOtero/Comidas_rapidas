<?php
session_start();
include '../../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['login_error'] = "Debes iniciar sesión primero.";
    header("Location: ../reserva.php");
    exit;
}

$idUsuario = $_SESSION['id_usuario'];
$idMesa = $_POST['mesa'] ?? null;
$fecha = $_POST['fecha'] ?? null;

if (!$idMesa || !$fecha) {
    die("Datos incompletos para realizar la reserva.");
}

try {
    // Obtenemos hora y estado desde la tabla mesa (base bd_mesas)
    $sqlMesa = "SELECT hora, estado FROM mesa WHERE id_mesa = :id_mesa AND fecha = :fecha";
    $stmtMesa = $conn->prepare($sqlMesa);
    $stmtMesa->bindParam(':id_mesa', $idMesa);
    $stmtMesa->bindParam(':fecha', $fecha);
    $stmtMesa->execute();
    $mesa = $stmtMesa->fetch(PDO::FETCH_ASSOC);

    if (!$mesa) {
        die("Mesa no encontrada.");
    }

    if (strtolower($mesa['estado']) !== 'disponible') {
        die("La mesa ya está reservada.");
    }

    $hora = $mesa['hora'];

    // Insertamos la reserva en base bd_reservas (o la que corresponda)
    $sqlReserva = "INSERT INTO reserva (id_usuario, id_mesa, fecha, hora, estado_reserva) 
                   VALUES (:id_usuario, :id_mesa, :fecha, :hora, 'confirmada')";
    $stmtReserva = $conn->prepare($sqlReserva);
    $stmtReserva->bindParam(':id_usuario', $idUsuario);
    $stmtReserva->bindParam(':id_mesa', $idMesa);
    $stmtReserva->bindParam(':fecha', $fecha);
    $stmtReserva->bindParam(':hora', $hora);
    $stmtReserva->execute();

    // Cambiamos el estado de la mesa a 'reservada'
    $sqlUpdateMesa = "UPDATE mesa SET estado = 'reservada' WHERE id_mesa = :id_mesa AND fecha = :fecha";
    $stmtUpdate = $conn->prepare($sqlUpdateMesa);
    $stmtUpdate->bindParam(':id_mesa', $idMesa);
    $stmtUpdate->bindParam(':fecha', $fecha);
    $stmtUpdate->execute();


    $_SESSION['mensaje_exito'] = "✅ ¡Mesa reservada con éxito!";
    header("Location: reserva_usuario.php");
    exit;

    header("Location: reserva_usuario.php");
    exit;

} catch (PDOException $e) {
    die("Error en la reserva: " . $e->getMessage());
}

