<?php
session_start();
include '../../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['login_error'] = "Debes iniciar sesión primero.";
    header("Location: ../reserva.php");
    exit;
}

date_default_timezone_set('America/Bogota'); // Pon esto antes de cualquier uso de date()
$idUsuario = $_SESSION['id_usuario'];

$sqlReservas = "SELECT r.id_reserva, r.fecha, r.hora, r.id_mesa, m.capacidad, r.estado_reserva,
                EXISTS (
                    SELECT 1 FROM pedido p WHERE p.id_reserva = r.id_reserva
                ) AS tiene_pedido
                FROM reserva r
                JOIN mesa m ON r.id_mesa = m.id_mesa
                WHERE r.id_usuario = :id_usuario
                ORDER BY r.fecha DESC, r.hora DESC";


$stmtReservas = $conn->prepare($sqlReservas);
$stmtReservas->bindParam(':id_usuario', $idUsuario);
$stmtReservas->execute();
$reservasActivas = $stmtReservas->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Mis Reservas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../assets/css/estilo.css" />
  <link rel="stylesheet" href="../../assets/css/reserva_usuario.css" />
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
    </div>  

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
        <a href="reserva_usuario.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Hacer Reserva
        </a>
        <a href="../../auth/logout.php" class="btn btn-danger">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </a>
        </div>

        <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success text-center fs-5 fw-bold">
            <?= $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']); ?>
        </div>
        <?php endif; ?>

       <?php if ($reservasActivas): ?>
    <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
        <?php foreach ($reservasActivas as $reserva): ?>
        <div class="col">
            <div class="card border border-dark shadow-sm h-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span><strong>Reserva #<?= $reserva['id_reserva']; ?></strong></span>
                    <small><?= date('d/m/Y', strtotime($reserva['fecha'])) . ' - ' . date('g:i A', strtotime($reserva['hora'])); ?></small>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Mesa:</strong> <?= $reserva['id_mesa']; ?><br>
                        <strong>Capacidad:</strong> <?= $reserva['capacidad']; ?><br>
                        <strong>Estado:</strong>
                        <span class="<?= $reserva['estado_reserva'] === 'cancelada' ? 'text-danger' : 'text-success' ?>">
                            <?= ucfirst($reserva['estado_reserva']); ?>
                        </span>
                    </p>

                    <?php
                        // Combina fecha y hora de la reserva
                        $fechaHoraReserva = date('Y-m-d H:i:s', strtotime($reserva['fecha'] . ' ' . $reserva['hora']));
                        // Calcula el límite de media hora antes
                        $limite = date('Y-m-d H:i:s', strtotime($fechaHoraReserva . ' -30 minutes'));
                        // Obtiene la fecha y hora actual
                        $ahora = date('Y-m-d H:i:s');
                    ?>

                    <?php if (
                        $reserva['estado_reserva'] === 'confirmada' &&
                        $ahora <= $limite &&
                        $reserva['tiene_pedido'] == 0
                    ): ?>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="abrirModalPedido(<?= $reserva['id_reserva']; ?>)">
                            <i class="bi bi-journal-plus"></i> Hacer Pedido
                        </button>
                        <form method="POST" action="cancelar_reserva.php" onsubmit="return confirm('¿Estás seguro de cancelar esta reserva?');">
                            <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva']; ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-x-circle"></i> Cancelar Reserva
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-warning text-center">
        No tienes reservas registradas.
    </div>
<?php endif; ?>

    </div>


    <!-- Modal para hacer pedido -->
<form method="POST" action="agregar_pedido.php" id="formPedido">
  <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="modalPedidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPedidoLabel">Seleccione sus comidas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="row row-cols-2 row-cols-md-3 g-3 justify-content-center">
            <?php
              $sqlComidas = "SELECT id_comida, nombre, precio, img FROM comida";
              $stmtComidas = $conn->prepare($sqlComidas);
              $stmtComidas->execute();
              $comidas = $stmtComidas->fetchAll(PDO::FETCH_ASSOC);
              foreach ($comidas as $comida):
              $imgSrc = $comida['img'] ? 'data:image/jpeg;base64,' . base64_encode($comida['img']) : '../../assets/img/default.jpg';
            ?>
            <div class="col d-flex justify-content-center">
              <div class="card h-100 comida-card">
                <img src="<?= $imgSrc ?>" class="card-img-top rounded" alt="Imagen Comida" >
                <div class="card-body p-2 d-flex flex-column align-items-center">
                  <h6 class="card-title mb-1 text-center"><?= htmlspecialchars($comida['nombre']) ?></h6>
                  <p class="card-text text-muted small mb-1">Precio: $<?= htmlspecialchars($comida['precio']) ?></p>
                  <div class="form-check">
                    <input class="form-check-input comida-checkbox" type="checkbox" name="comidas[]" value="<?= $comida['id_comida'] ?>" id="pedido_comida_<?= $comida['id_comida'] ?>">
                    <label class="form-check-label small" for="pedido_comida_<?= $comida['id_comida'] ?>">Seleccionar</label>
                  </div>
                  <input type="number" name="cantidades[<?= $comida['id_comida'] ?>]" class="form-control form-control-sm mt-1 cantidad-input" placeholder="Cantidad" min="1" max="20" disabled />
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between align-items-center">
          <div class="fw-bold text-success fs-5" id="totalPedido">Total: $0</div>
          <input type="hidden" name="id_reserva" id="idReservaPedido" />
          <button type="submit" class="btn btn-success">Confirmar Pedido</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</form>
  
    <?php include '../../includes/footer_reserva.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>



<script>
document.addEventListener('DOMContentLoaded', function () {
  // Mostrar/ocultar input de cantidad al marcar checkbox
  document.querySelectorAll('.comida-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
      const inputCantidad = this.closest('.card-body').querySelector('.cantidad-input');
      if (this.checked) {
        inputCantidad.style.display = 'inline-block';
        if (!inputCantidad.value) inputCantidad.value = 1;
        inputCantidad.max = 20;
        inputCantidad.min = 1;
      } else {
        inputCantidad.style.display = 'none';
        inputCantidad.value = '';
        inputCantidad.classList.remove('is-invalid');
      }
      calcularTotalComidas();
    });
  });

  // Validación de cantidad al perder foco o escribir
  document.querySelectorAll('.cantidad-input').forEach(input => {
    input.addEventListener('blur', function () {
      let val = parseInt(this.value);
      if (isNaN(val) || val < 1) {
        this.value = 1;
      } else if (val > 20) {
        this.value = 20;
      }
      this.classList.remove('is-invalid');
      calcularTotalComidas();
    });

    input.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '');
      this.classList.remove('is-invalid');
      calcularTotalComidas();
    });

    // Ocultar por defecto si está vacío
    if (!input.value) {
      input.style.display = 'none';
    }
  });

 document.getElementById('formPedido').addEventListener('submit', function(e) {
  let valid = false;
  document.querySelectorAll('#modalPedido .comida-checkbox').forEach(cb => {
    if (cb.checked) {
      const input = cb.closest('.card').querySelector('.cantidad-input');
      const cantidad = parseInt(input.value);
      if (cantidad >= 1 && cantidad <= 20) {
        valid = true;
      }
    }
  });

  if (!valid) {
    e.preventDefault();
    alert("Selecciona al menos una comida con una cantidad válida (1-20).");
  }
});

  // Función para calcular el total
  function calcularTotalComidas() {
    let total = 0;
    document.querySelectorAll('.comida-checkbox').forEach(checkbox => {
      if (checkbox.checked) {
        const card = checkbox.closest('.card-body');
        const cantidadInput = card.querySelector('.cantidad-input');
        const cantidad = parseInt(cantidadInput.value) || 0;
        const precioTexto = card.querySelector('.card-text').textContent;
        const precio = parseInt(precioTexto.replace(/[^\d]/g, '')) || 0;
        total += precio * cantidad;
      }
    });
    document.getElementById('totalComidas').textContent = 'Total: $' + total;
  }

  // Listeners para recalcular total
  document.querySelectorAll('.comida-checkbox, .cantidad-input').forEach(elem => {
    elem.addEventListener('change', calcularTotalComidas);
    elem.addEventListener('input', calcularTotalComidas);
  });
});
</script>


<script>
let modalPedido = new bootstrap.Modal(document.getElementById('modalPedido'));

function abrirModalPedido(idReserva) {
  document.getElementById('idReservaPedido').value = idReserva;
  // Limpiar selección previa
  document.querySelectorAll('#modalPedido .comida-checkbox').forEach(cb => {
    cb.checked = false;
    cb.closest('.card').querySelector('.cantidad-input').value = '';
    cb.closest('.card').querySelector('.cantidad-input').disabled = true;
  });
  document.getElementById('totalPedido').textContent = 'Total: $0';
  modalPedido.show();
}

// Habilitar/deshabilitar input cantidad según checkbox
document.querySelectorAll('#modalPedido .comida-checkbox').forEach(cb => {
  cb.addEventListener('change', function() {
    let cantidadInput = this.closest('.card').querySelector('.cantidad-input');
    cantidadInput.disabled = !this.checked;
    if (!this.checked) cantidadInput.value = '';
    calcularTotalPedido();
  });
});

// Calcular total al cambiar cantidad
document.querySelectorAll('#modalPedido .cantidad-input').forEach(input => {
  input.addEventListener('input', calcularTotalPedido);
});

function calcularTotalPedido() {
  let total = 0;
  document.querySelectorAll('#modalPedido .comida-checkbox').forEach(cb => {
    if (cb.checked) {
      let cantidad = parseInt(cb.closest('.card').querySelector('.cantidad-input').value) || 0;
      let precio = parseFloat(cb.closest('.card').querySelector('.card-text').textContent.replace(/[^0-9.]/g, ''));
      if (cantidad > 20) {
        cb.closest('.card').querySelector('.cantidad-input').value = 20;
        cantidad = 20;
      }
      total += cantidad * precio;
    }
  });
  document.getElementById('totalPedido').textContent = 'Total: $' + total;
}
</script>





</body>
</html>
