<?php
session_start();
include '../../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['login_error'] = "Debes iniciar sesión primero.";
    header("Location: ../reserva.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = $_SESSION['id_usuario'];
    $idReserva = $_POST['id_reserva'] ?? null;
    $comidas = $_POST['comidas'] ?? [];
    $cantidades = $_POST['cantidades'] ?? [];

    if ($idReserva && !empty($comidas)) {
        try {
            $conn->beginTransaction();

            // 1. Generar un ID de pedido único (por ejemplo, basado en timestamp)
            $idPedido = time(); // También puedes usar uniqid() o una lógica más robusta

            // 2. Obtener precios de las comidas seleccionadas
            $placeholders = implode(',', array_fill(0, count($comidas), '?'));
            $sqlPrecios = "SELECT id_comida, precio FROM comida WHERE id_comida IN ($placeholders)";
            $stmt = $conn->prepare($sqlPrecios);
            $stmt->execute($comidas);
            $precios = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // id_comida => precio

            // 3. Insertar los pedidos
            $sqlInsert = "INSERT INTO pedido (id_pedido, id_comida, id_reserva, cantidad, monto)
                          VALUES (:id_pedido, :id_comida, :id_reserva, :cantidad, :monto)";
            $stmtInsert = $conn->prepare($sqlInsert);

            foreach ($comidas as $idComida) {
                $cantidad = isset($cantidades[$idComida]) ? (int)$cantidades[$idComida] : 1;
                if ($cantidad < 1 || $cantidad > 20) continue;

                $precio = $precios[$idComida] ?? 0;
                $monto = $precio * $cantidad;

                $stmtInsert->execute([
                    ':id_pedido' => $idPedido,
                    ':id_comida' => $idComida,
                    ':id_reserva' => $idReserva,
                    ':cantidad' => $cantidad,
                    ':monto' => $monto
                ]);
            }

            $conn->commit();
            $_SESSION['mensaje_exito'] = "¡Pedido registrado con éxito!";
        } catch (Exception $e) {
            $conn->rollBack();
            $_SESSION['mensaje_exito'] = "Error al registrar el pedido: " . $e->getMessage();
        }
    } else {
        $_SESSION['mensaje_exito'] = "Debes seleccionar al menos una comida.";
    }

    header("Location: pedido_usuario.php");
    exit;
}
?>
