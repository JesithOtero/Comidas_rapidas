<?php
include __DIR__ . '/../../../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_comida'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $sql = "UPDATE comida SET nombre = :nombre, precio = :precio, img = :img WHERE id_comida = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':img', $imagen, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $id);
    } else {
        $sql = "UPDATE comida SET nombre = :nombre, precio = :precio WHERE id_comida = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id', $id);
    }

    if ($stmt->execute()) {
        header("Location: ../comida.php");
        exit();
    } else {
        echo "Error al actualizar comida.";
    }
}
?>
