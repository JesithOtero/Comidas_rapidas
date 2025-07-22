<?php
include __DIR__ . '/../../../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mesa = $_POST['id_mesa'];
    $capacidad = $_POST['capacidad'];
    $estado = $_POST['estado'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    try {
        $sql = "UPDATE mesa SET capacidad = :capacidad, estado = :estado, fecha = :fecha, hora = :hora WHERE id_mesa = :id_mesa";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':capacidad', $capacidad);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':id_mesa', $id_mesa, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../mesa.php?mensaje=actualizado");
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar mesa: " . $e->getMessage();
    }
} else {
    header("Location: ../mesa.php");
    exit;
}

