<?php
include __DIR__ . '/../../../config/conexion.php';

$id_usuario = $_POST['id_usuario'] ?? null;

if ($id_usuario) {
    try {
        $conn->beginTransaction();

        // Obtener IDs de reservas del usuario
        $stmt = $conn->prepare("SELECT id_reserva, id_mesa FROM reserva WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($reservas) {
            $idsReserva = array_column($reservas, 'id_reserva');
            $idsMesa = array_unique(array_column($reservas, 'id_mesa'));

            // Eliminar pedidos relacionados
            $placeholders = implode(',', array_fill(0, count($idsReserva), '?'));
            $conn->prepare("DELETE FROM pedido WHERE id_reserva IN ($placeholders)")->execute($idsReserva);

            // Eliminar reservas
            $conn->prepare("DELETE FROM reserva WHERE id_reserva IN ($placeholders)")->execute($idsReserva);

            // Cambiar estado de mesas a 'disponible'
            $mesaPlaceholders = implode(',', array_fill(0, count($idsMesa), '?'));
            $conn->prepare("UPDATE mesa SET estado = 'disponible' WHERE id_mesa IN ($mesaPlaceholders)")->execute($idsMesa);
        }

        // Eliminar usuario
        $conn->prepare("DELETE FROM persona WHERE id_usuario = ?")->execute([$id_usuario]);

        $conn->commit();
        header("Location: ../clientes.php");
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID de usuario no especificado.";
}
?>
