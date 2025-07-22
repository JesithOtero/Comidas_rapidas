<?php
session_start();
if (isset($_SESSION['login_error'])) {
    echo '<div class="alert alert-danger mt-3 text-center">' . $_SESSION['login_error'] . '</div>';
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>COMIDAS RAPIDAS</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="top-bar">
      <img src="../assets/img/logo.png" alt="Logo de comidas" class="logo">
      <h1 class="titulo">COMIDAS RAPIDAS</h1>
    </div>
    <div class="curva"></div>
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="quienessomos.php"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pillsNavbar"
          aria-controls="pillsNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="pillsNavbar">
          <ul class="nav nav-pills mb-3 ms-auto" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link" onclick="location.href='quienessomos.php'">Inicio</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" onclick="location.href='ubicacion.php'">Ubicación</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" onclick="location.href='productos.php'">Productos</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link active" onclick="location.href='reserva.php'">Reserva</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

<div class="d-flex justify-content-center align-items-center my-5">
  <div class="card" style="width: 23.5rem;">
    <div class="card-body">
      <div class="text-center my-3">
        <i class="bi bi-person-circle fs-1"></i>
      </div>
      <form class="p-4 border rounded shadow-sm" method="POST" action="../auth/login.php">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">CORREO</label>
          <input type="email" class="form-control" id="exampleInputEmail1" name="email" required>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="exampleInputPassword1" name="password" minlength="8" maxlength="20" required>
        </div> 
<div >
  <button type="submit" class="btn btn-primary w-50 mb-2 " name="login">Entrar</button> 
  <p>
  ¿Aún no eres miembro?
  <a href="#" class="text-primary text-decoration-underline" data-bs-toggle="modal" data-bs-target="#exampleModal2">
    Regístrate Aquí
  </a>
</p>

</div>

      </form>
    </div>
  </div>
</div>

<!-- Modal de Registro -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel2">Registro</h1>
        <i class="bi bi-clipboard2-data"></i>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form class="p-4 border rounded shadow-sm" method="POST" action="../auth/registro.php">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
          </div>
          <div class="mb-3">
            <label for="celular" class="form-label">Número de Celular</label>
            <input type="number" class="form-control" id="celular" name="celular" required>
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
          </div>
          <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" class="form-control" placeholder="maximo 20 y minimo 8 caracteres" id="contrasena" name="contrasena" minlength="8" maxlength="20" required>
          </div>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Registrarme</button>
        </form>

      </div>
    </div>
  </div>
</div>


  <?php include '../includes/footer.php'; ?>

</body>
</html>
