<?php
include __DIR__ . '/../../../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $n_celular = $_POST['n_celular'];
    $tipo = $_POST['tipo'];

    $sql = "UPDATE persona SET nombre = :nombre, apellido = :apellido, correo = :correo, n_celular = :n_celular, tipo = :tipo WHERE id_usuario = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':n_celular', $n_celular);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ../clientes.php");
        exit;
    } else {
        echo "Error al actualizar el usuario.";
    }
}
