<?php
session_start();
include '../../config/conexion.php';

if (!isset($_POST['id_reserva'])) {
    header("Location: pedido_usuario.php");
    exit;
}

$idReserva = $_POST['id_reserva'];

$sql = "UPDATE reserva SET estado_reserva = 'cancelada' WHERE id_reserva = :id_reserva";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_reserva', $idReserva);

if ($stmt->execute()) {
    $_SESSION['mensaje_exito'] = "Reserva cancelada exitosamente.";
} else {
    $_SESSION['mensaje_exito'] = "Error al cancelar la reserva.";
}

header("Location: pedido_usuario.php");
exit;
?>
