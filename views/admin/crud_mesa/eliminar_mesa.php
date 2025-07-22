<?php
include __DIR__ . '/../../../config/conexion.php';

$id_mesa = $_POST['id_mesa'] ?? null;

if ($id_mesa) {
    try {
        $conn->beginTransaction();

        // Obtener IDs de reservas asociadas
        $stmt = $conn->prepare("SELECT id_reserva FROM reserva WHERE id_mesa = ?");
        $stmt->execute([$id_mesa]);
        $reservas = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($reservas) {
            $placeholders = implode(',', array_fill(0, count($reservas), '?'));

            // Borrar pedidos y reservas
            $conn->prepare("DELETE FROM pedido WHERE id_reserva IN ($placeholders)")->execute($reservas);
            $conn->prepare("DELETE FROM reserva WHERE id_reserva IN ($placeholders)")->execute($reservas);
        }

        // Borrar mesa
        $conn->prepare("DELETE FROM mesa WHERE id_mesa = ?")->execute([$id_mesa]);

        $conn->commit();
        header("Location: ../mesa.php");
        exit;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID de mesa no especificado.";
}
?>
