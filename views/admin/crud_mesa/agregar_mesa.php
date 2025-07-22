<?php
session_start();
include __DIR__ . '/../../../config/conexion.php';

// Validar que vengan los datos necesarios
if (
    isset($_POST['capacidad'], $_POST['estado'], $_POST['fecha'], $_POST['hora']) &&
    !empty($_POST['capacidad']) &&
    !empty($_POST['estado']) &&
    !empty($_POST['fecha']) &&
    !empty($_POST['hora'])
) {
    // Limpiar y asignar variables
    $capacidad = (int) $_POST['capacidad'];
    $estado = trim($_POST['estado']);
    $fecha = trim($_POST['fecha']);
    $hora = trim($_POST['hora']);

    // Validar valores básicos
    if ($capacidad <= 0) {
        $_SESSION['error'] = "La capacidad debe ser un número positivo.";
        header('Location: ../mesa.php');
        exit;
    }

    // Preparar e insertar en la base de datos
    $sql = "INSERT INTO mesa (capacidad, estado, fecha, hora) VALUES (:capacidad, :estado, :fecha, :hora)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([
            ':capacidad' => $capacidad,
            ':estado' => $estado,
            ':fecha' => $fecha,
            ':hora' => $hora,
        ]);
        $_SESSION['success'] = "Mesa agregada correctamente.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al agregar la mesa: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Todos los campos son obligatorios.";
}

// Redirigir a la página de mesas
header('Location: ../mesa.php');
exit;
