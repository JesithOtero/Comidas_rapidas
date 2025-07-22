<?php
include __DIR__ . '/../../../config/conexion.php';

$id_comida = $_POST['id_comida'] ?? null;

if ($id_comida) {
    // Elimina primero los pedidos asociados a la comida
    $conn->exec("DELETE FROM pedido WHERE id_comida = $id_comida");
    // Ahora elimina la comida
    $conn->exec("DELETE FROM comida WHERE id_comida = $id_comida");
    header("Location: ../comida.php");
} else {
    echo "ID de comida no especificado.";
}
?>
