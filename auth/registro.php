<?php
require_once '../config/conexion.php';

$mensaje = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $tipo = 'usuario'; 

    if (empty($nombre) || empty($correo) || empty($contrasena)) {
        $mensaje = "Por favor completa todos los campos requeridos.";
    } else {
        $query = "SELECT id_usuario FROM persona WHERE correo = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$correo]);

        if ($stmt->rowCount() > 0) {
            $mensaje = "Este correo ya está registrado.";
        } else {

            $query = "INSERT INTO persona (nombre, apellido, correo, contraseña, n_celular, tipo) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            
            if ($stmt->execute([$nombre, $apellido, $correo, $contrasena, $celular, $tipo])) {
                $mensaje = "¡Registro exitoso! Ahora puedes iniciar sesión.";
            } else {
                $mensaje = "Error al registrar: " . $stmt->errorInfo()[2];
            }

            $stmt = null;
        }
    }

    $stmt = null;
    $conn = null;
}
?>


<?php if (!empty($mensaje)): ?>
    <script type="text/javascript">
        alert("<?php echo $mensaje; ?>");
        window.location.href = "../views/reserva.php"; 
    </script>
<?php endif; ?>
