<?php
session_start();

include __DIR__ . '/../../controller/controlador_usuario.php';



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
  <title>Usuarios</title>
</head>
<body>
<?php include __DIR__ . '/../../includes/sidebar.php'; ?>

<main>
  <div class="contenido container mt-4">
    <h1 class="text-center">Usuarios</h1>
    <p class="text-center">Aquí puedes gestionar todos los usuarios del sistema (clientes y administradores).</p>
    <hr />

    <form method="GET" class="row mb-3">
      <div class="col-md-6">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre..." value="<?php echo htmlspecialchars($buscar); ?>" />
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
      </div>
      <div class="col-md-2 text-end">
        <a href="descargar/reporte_usuarios.php" class="btn btn-secondary"><i class="bi bi-filetype-pdf"></i> Reporte PDF</a>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Tipo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($personas)): ?>
            <?php foreach ($personas as $persona): ?>
              <tr>
                <td><?php echo $persona['id_usuario']; ?></td>
                <td><?php echo htmlspecialchars($persona['nombre']); ?></td>
                <td><?php echo htmlspecialchars($persona['apellido']); ?></td>
                <td><?php echo htmlspecialchars($persona['correo']); ?></td>
                <td><?php echo htmlspecialchars($persona['n_celular']); ?></td>
                <td><?php echo htmlspecialchars($persona['tipo']); ?></td>
                <td>
                  <!-- Botón para actualizar (abre modal) -->
                  <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditar<?php echo $persona['id_usuario']; ?>">
                    <i class="bi bi-pencil"></i> Actualizar
                  </button>

                  <!-- Botón para eliminar (abre modal) -->
                  <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $persona['id_usuario']; ?>">
                    <i class="bi bi-trash"></i> Eliminar
                  </button>

                  <!-- Modal Editar -->
                  <div class="modal fade" id="modalEditar<?php echo $persona['id_usuario']; ?>" tabindex="-1" aria-labelledby="modalEditarLabel<?php echo $persona['id_usuario']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <form action="crud_clientes/actualizar_usuario.php" method="POST" class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalEditarLabel<?php echo $persona['id_usuario']; ?>">Actualizar Usuario</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="id_usuario" value="<?php echo $persona['id_usuario']; ?>" />
                          <div class="mb-3">
                            <label for="nombre<?php echo $persona['id_usuario']; ?>" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre<?php echo $persona['id_usuario']; ?>" name="nombre" value="<?php echo htmlspecialchars($persona['nombre']); ?>" required />
                          </div>
                          <div class="mb-3">
                            <label for="apellido<?php echo $persona['id_usuario']; ?>" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido<?php echo $persona['id_usuario']; ?>" name="apellido" value="<?php echo htmlspecialchars($persona['apellido']); ?>" required />
                          </div>
                          <div class="mb-3">
                            <label for="correo<?php echo $persona['id_usuario']; ?>" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo<?php echo $persona['id_usuario']; ?>" name="correo" value="<?php echo htmlspecialchars($persona['correo']); ?>" required />
                          </div>
                          <div class="mb-3">
                            <label for="n_celular<?php echo $persona['id_usuario']; ?>" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="n_celular<?php echo $persona['id_usuario']; ?>" name="n_celular" value="<?php echo htmlspecialchars($persona['n_celular']); ?>" />
                          </div>
                          <div class="mb-3">
                            <label for="tipo<?php echo $persona['id_usuario']; ?>" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo<?php echo $persona['id_usuario']; ?>" name="tipo" required>
                              <option value="usuario" <?php if($persona['tipo']=='usuario') echo 'selected'; ?>>Usuario</option>
                              <option value="admin" <?php if($persona['tipo']=='admin') echo 'selected'; ?>>Admin</option>
                            </select>
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
                  <div class="modal fade" id="modalEliminar<?php echo $persona['id_usuario']; ?>" tabindex="-1" aria-labelledby="modalEliminarLabel<?php echo $persona['id_usuario']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <form action="crud_clientes/eliminar_usuario.php" method="POST" class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalEliminarLabel<?php echo $persona['id_usuario']; ?>">Eliminar Usuario</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                          <p>¿Estás seguro que deseas eliminar al usuario <strong><?php echo htmlspecialchars($persona['nombre'].' '.$persona['apellido']); ?></strong>?</p>
                          <input type="hidden" name="id_usuario" value="<?php echo $persona['id_usuario']; ?>" />
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                      </form>
                    </div>
                  </div>

                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center">No hay usuarios registrados</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($paginaActual <= 1) ? 'disabled' : ''; ?>">
          <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>&buscar=<?php echo urlencode($buscar); ?>" aria-label="Anterior">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= max(1, $totalPaginas); $i++): ?>
          <li class="page-item <?php echo ($paginaActual == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($buscar); ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?php echo ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
          <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>&buscar=<?php echo urlencode($buscar); ?>" aria-label="Siguiente">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</main>
</body>
</html>
