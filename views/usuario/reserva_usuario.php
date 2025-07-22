<?php
session_start();
include '../../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['login_error'] = "Debes iniciar sesión primero.";
    header("Location: ../reserva.php");
    exit;
}

$fechaSeleccionada = isset($_GET['fecha']) ? $_GET['fecha'] : (isset($_POST['fecha']) ? $_POST['fecha'] : null);
date_default_timezone_set('America/Bogota'); // Pon esto antes de cualquier uso de date()

$hoy = date('Y-m-d');
$horaActual = date('H:i:s');
$horaMinima = date('H:i:s', strtotime($horaActual . ' +30 minutes'));

$mesas = [];
if ($fechaSeleccionada) {
    if (trim($fechaSeleccionada) === $hoy) {
        // Solo para hoy, filtra por hora mínima
        $sqlMesas = "SELECT id_mesa, capacidad, estado, hora FROM mesa WHERE fecha = :fecha AND hora >= :horaMinima ORDER BY hora, id_mesa";
        $stmtMesas = $conn->prepare($sqlMesas);
        $stmtMesas->bindParam(':fecha', $fechaSeleccionada);
        $stmtMesas->bindParam(':horaMinima', $horaMinima);
    } else {
        // Para cualquier otro día, muestra todas las horas
        $sqlMesas = "SELECT id_mesa, capacidad, estado, hora FROM mesa WHERE fecha = :fecha ORDER BY hora, id_mesa";
        $stmtMesas = $conn->prepare($sqlMesas);
        $stmtMesas->bindParam(':fecha', $fechaSeleccionada);
    }
    $stmtMesas->execute();
    $mesas = $stmtMesas->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Reserva de Mesas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../assets/css/estilo.css" />
  <link rel="stylesheet" href="../../assets/css/reserva_usuario.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
  
  </style>
</head>
<body>

<header class="header">
  <div class="top-bar">
    <img src="../../assets/img/logo.png" alt="Logo de comidas" class="logo" />
    <h1 class="titulo">COMIDAS RAPIDAS</h1>
  </div>
  <div class="curva"></div>
</header>

<div class="container mt-5">
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
      <div class="alert alert-success text-center fs-5 fw-bold">
        <?php 
          echo $_SESSION['mensaje_exito']; 
          unset($_SESSION['mensaje_exito']); // Mostrar el mensaje solo una vez
        ?>
      </div>
    <?php endif; ?>

   <div class="d-flex justify-content-between mb-3">
  <div>
    <a href="pedido_usuario.php" class="btn btn-secondary">
      <i class="bi bi-list-check"></i> Ir a Pedidos
    </a>
  </div>
  <div>
    <a href="../../auth/logout.php" class="btn btn-danger">
      <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
    </a>
  </div>
</div>

 
  <form method="POST" action="agregar_reserva.php" id="formReserva">
    <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fechaSeleccionada); ?>" />
    <div class="text-center mb-2">
      <label class="fw-bold fs-1">SELECCIONE SU MESA</label>
    </div>

    <div class="card mesa-container p-4 mb-5">
      <div class="mb-4 text-center">
        <label for="fecha" class="form-label fw-bold fs-4">Selecciona una fecha:</label>
        <input
          type="date"
          name="fecha"
          id="fecha"
          class="form-control d-inline-block w-auto"
          value="<?php echo htmlspecialchars($fechaSeleccionada); ?>"
          min="<?php echo $hoy; ?>"
          required
          form="filtroFecha"
        />
        <button type="submit" form="filtroFecha" class="btn btn-secondary ms-2">Filtrar</button>
      </div>

      <?php if (!$fechaSeleccionada): ?>
        <p class="text-center text-muted fs-5">Por favor selecciona una fecha para mostrar las mesas.</p>
      <?php else: ?>
        <?php if (empty($mesas)): ?>
          <p class="text-center text-muted fs-5">No hay mesas disponibles para esta fecha.</p>
        <?php else: ?>
          <div class="row g-4 justify-content-center">
            <?php foreach ($mesas as $mesa):
              $estado = strtolower(trim($mesa['estado']));
              $reservada = ($estado === 'reservado');
              $disponible = ($estado === 'disponible');

              if (!empty($mesa['hora'])) {
                  $hora_obj = new DateTime($mesa['hora']);
                  $hora_formateada = $hora_obj->format('g:i A');
              } else {
                  $hora_formateada = '-';
              }
            ?>
              <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="card mesa-card">
                  <div class="card-body d-flex flex-column align-items-center">
                    <img src="../../assets/img/mesa.png" alt="Mesa" class="img-fluid mb-2" />
                    <p class="mb-1 fw-bold">Capacidad: <?php echo htmlspecialchars($mesa['capacidad']); ?></p>
                    <p class="mb-3 text-muted">Hora: <?php echo htmlspecialchars($hora_formateada); ?></p>

                    <div class="d-flex align-items-center justify-content-center gap-2">
                      <?php if ($reservada): ?>
                        <input type="radio" disabled />
                        <i class="bi bi-calendar-x-fill text-danger fs-5" title="Reservada"></i>
                      <?php elseif ($disponible): ?>
                        <input type="radio" name="mesa" value="<?php echo $mesa['id_mesa']; ?>" />
                        <i class="bi bi-calendar-check-fill text-success fs-5" title="Disponible"></i>
                      <?php else: ?>
                        <input type="radio" disabled />
                        <i class="bi bi-calendar-x-fill text-muted fs-5" title="No disponible"></i>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <?php if ($fechaSeleccionada && !empty($mesas)): ?>
        <div class="text-center mt-4">
          <button type="submit" id="elegirMesaBtn" class="btn btn-primary" disabled>
            Reservar Mesa
          </button>
        </div>
      <?php endif; ?>
    </div>
  </form>

  <form id="filtroFecha" method="GET" action="" class="d-none"></form>
</div>




<?php include '../../includes/footer_reserva.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/reserva.js"></script>

</body>
</html>
