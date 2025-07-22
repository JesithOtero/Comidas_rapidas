<?php
session_start();
include __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Por favor, ingrese ambos campos.";
        header("Location: ../views/reserva.php");
        exit;
    }

    $sql = "SELECT * FROM persona WHERE correo = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verifica la contraseña usando password_verify
        if ($password === $user['contraseña']) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['tipo'] = $user['tipo'];

            // Redirige según el tipo de usuario
            if ($user['tipo'] === 'usuario') {
                header("Location: ../views/usuario/reserva_usuario.php");
            } elseif ($user['tipo'] === 'admin') {
                header("Location: ../views/admin/inicio.php");
            } else {
                $_SESSION['login_error'] = "Tipo de usuario no válido.";
                header("Location: ../views/reserva.php");
            }
            exit;
        } else {
            $_SESSION['login_error'] = "Contraseña incorrecta.";
        }
    } else {
        $_SESSION['login_error'] = "Correo o contraseña incorrectos.";
    }

    header("Location: ../views/reserva.php");
    exit;
}
?>
