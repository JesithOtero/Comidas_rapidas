<?php
session_start();

include __DIR__ . '/../../controller/controlador_mesa.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../../assets/css/sidebar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <title>Mesas</title>
</head>
<body>
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

<main>
  <div class="contenido container mt-4">
    <h1 class="text-center">Mesas</h1>
    <p class="text-center">Aquí puedes gestionar todas las mesas registradas en el sistema.</p>
    <hr />


   <form method="GET" class="row mb-3 align-items-center">
      <div class="col-md-6">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por Capacidad" value="<?php echo htmlspecialchars($buscar); ?>" />
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
      </div>
      <div class="col-md-4 text-end">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarMesa">
          <i class="bi bi-plus-circle"></i> Agregar Mesa
        </button>
      </div>
    </form>
    
    <div>
      <div class="col-md-12 text-end">
        <a href="descargar/reporte_mesa.php" class="btn btn-secondary"><i class="bi bi-filetype-pdf"></i> Reporte PDF</a>
      </div>
    </div>



    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Capacidad</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($mesas)): ?>
            <?php foreach ($mesas as $mesa): ?>
              <tr>
                <td><?php echo $mesa['id_mesa']; ?></td>
                <td><?php echo htmlspecialchars($mesa['capacidad']); ?></td>
                <td><?php echo htmlspecialchars($mesa['estado']); ?></td>
                <td><?php echo htmlspecialchars($mesa['fecha']); ?></td>
                <td><?php echo htmlspecialchars($mesa['hora']); ?></td>
                <td>
                  <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar<?php echo $mesa['id_mesa']; ?>"
                  >
                    <i class="bi bi-pencil"></i> Actualizar
                  </button>

                  <button
                    type="button"
                    class="btn btn-sm btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEliminar<?php echo $mesa['id_mesa']; ?>"
                  >
                    <i class="bi bi-trash"></i> Eliminar
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">No hay mesas registradas</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($paginaActual <= 1) ? 'disabled' : ''; ?>">
          <a
            class="page-link"
            href="?pagina=<?php echo $paginaActual - 1; ?>&buscar=<?php echo urlencode($buscar); ?>"
            aria-label="Anterior"
          >
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= max(1, $totalPaginas); $i++): ?>
          <li class="page-item <?php echo ($paginaActual == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($buscar); ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?php echo ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
          <a
            class="page-link"
            href="?pagina=<?php echo $paginaActual + 1; ?>&buscar=<?php echo urlencode($buscar); ?>"
            aria-label="Siguiente"
          >
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>

<!-- Modal Agregar Mesa -->
<div class="modal fade" id="modalAgregarMesa" tabindex="-1" aria-labelledby="modalAgregarMesaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="crud_mesa/agregar_mesa.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarMesaLabel">Agregar Nueva Mesa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="capacidadNueva" class="form-label">Capacidad</label>
          <input type="number" min="1" class="form-control" id="capacidadNueva" name="capacidad" required />
        </div>
        <div class="mb-3">
          <label for="estadoNuevo" class="form-label">Estado</label>
          <select class="form-select" id="estadoNuevo" name="estado" required>
            <option value="disponible">Disponible</option>
            <option value="reservada">Reservada</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="fechaNueva" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fechaNueva" name="fecha" required />
        </div>
        <div class="mb-3">
          <label for="horaNueva" class="form-label">Hora</label>
<select class="form-control" id="horaNueva" name="hora" required>
  <?php
    for ($h = 16; $h < 24; $h++) {
      foreach (['00', '30'] as $m) {
        $hora = sprintf('%02d:%s', $h, $m);
        echo "<option value=\"$hora\">$hora</option>";
      }
    }
  ?>
</select>        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Agregar Mesa</button>
      </div>
    </form>
  </div>
</div>

<!-- Modales Editar y Eliminar para cada mesa, colocados aquí al final -->
<?php foreach ($mesas as $mesa): ?>
  <!-- Modal Editar -->
  <div
    class="modal fade"
    id="modalEditar<?php echo $mesa['id_mesa']; ?>"
    tabindex="-1"
    aria-labelledby="modalEditarLabel<?php echo $mesa['id_mesa']; ?>"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form action="crud_mesa/actualizar_mesa.php" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarLabel<?php echo $mesa['id_mesa']; ?>">Actualizar Mesa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_mesa" value="<?php echo $mesa['id_mesa']; ?>" />
          <div class="mb-3">
            <label for="capacidad<?php echo $mesa['id_mesa']; ?>" class="form-label">Capacidad</label>
            <input
              type="number"
              min="1"
              class="form-control"
              id="capacidad<?php echo $mesa['id_mesa']; ?>"
              name="capacidad"
              value="<?php echo htmlspecialchars($mesa['capacidad']); ?>"
              required
            />
          </div>
          <div class="mb-3">
            <label for="estado<?php echo $mesa['id_mesa']; ?>" class="form-label">Estado</label>
            <select class="form-select" id="estado<?php echo $mesa['id_mesa']; ?>" name="estado" required>
              <option value="disponible" <?php echo ($mesa['estado'] === 'disponible') ? 'selected' : ''; ?>>Disponible</option>
              <option value="reservada" <?php echo ($mesa['estado'] === 'reservada') ? 'selected' : ''; ?>>Reservada</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="fecha<?php echo $mesa['id_mesa']; ?>" class="form-label">Fecha</label>
            <input
              type="date"
              class="form-control"
              id="fecha<?php echo $mesa['id_mesa']; ?>"
              name="fecha"
              value="<?php echo htmlspecialchars($mesa['fecha']); ?>"
              required
            />
          </div>
          <div class="mb-3">
            <label for="hora<?php echo $mesa['id_mesa']; ?>" class="form-label">Hora</label>
            <input
              type="time"
              class="form-control"
              id="hora<?php echo $mesa['id_mesa']; ?>"
              name="hora"
              value="<?php echo htmlspecialchars($mesa['hora']); ?>"
              required
            />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Eliminar -->
  <div
    class="modal fade"
    id="modalEliminar<?php echo $mesa['id_mesa']; ?>"
    tabindex="-1"
    aria-labelledby="modalEliminarLabel<?php echo $mesa['id_mesa']; ?>"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form action="crud_mesa/eliminar_mesa.php" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEliminarLabel<?php echo $mesa['id_mesa']; ?>">Eliminar Mesa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro que deseas eliminar la mesa con ID <strong><?php echo $mesa['id_mesa']; ?></strong>?</p>
          <input type="hidden" name="id_mesa" value="<?php echo $mesa['id_mesa']; ?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
<?php endforeach; ?>

</main>
  <!-- ...existing code... -->
<script>
  // Establecer fecha mínima en hoy
  const fechaInput = document.getElementById('fechaNueva');
  if (fechaInput) {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const minDate = `${yyyy}-${mm}-${dd}`;
    fechaInput.min = minDate;
  }

  // Limitar minutos a 00 o 30 en el input de hora
  const horaInput = document.getElementById('horaNueva');
  if (horaInput) {
    horaInput.addEventListener('input', function () {
      let [h, m] = this.value.split(':');
      if (m !== '00' && m !== '30') {
        m = (parseInt(m) < 30) ? '00' : '30';
        this.value = `${h}:${m}`;
      }
    });
    horaInput.step = 1800; // 1800 segundos = 30 minutos
  }

</script>
<!-- ...existing code... -->

</body>
</html>
