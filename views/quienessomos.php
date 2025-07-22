<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>COMIDAS RAPIDAS</title>
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <link rel="stylesheet" href="../assets/css/quienessomos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
</head>

<body>

  <header class="header">
    <div class="top-bar">
      <img src="../assets/img/logo.png" alt="Logo de comidas" class="logo">
      <h1 class="titulo">COMIDAS RAPIDAS</h1>
    </div>
    <div class="curva"></div>


    <!-- Navbar responsiva con nav-pills -->
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
              <button class="nav-link active" id="pills-home-tab" type="button" role="tab" aria-controls="pills-home"
                aria-selected="true" onclick="location.href='quienessomos.php'">Inicio</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-profile-tab" type="button" role="tab" aria-controls="pills-profile"
                aria-selected="false" onclick="location.href='ubicacion.php'">Ubicación</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-productos-tab" type="button" role="tab" aria-controls="pills-productos"
                aria-selected="false" onclick="location.href='productos.php'">Productos</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-reserva-tab" type="button" role="tab" aria-controls="pills-reserva"
                aria-selected="false" onclick="location.href='reserva.php'">Reserva</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="quienes-somos">
    <div class="container-quienes">
      <div class="columna-izquierda">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel"  data-bs-interval="2900">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="../assets/img/quienessomos1.jpeg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="../assets/img/quienessomos2.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="../assets/img/quienessomos3.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="../assets/img/quienessomos4.jpg" class="d-block w-100" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

      </div>
      <div class="columna-derecha">
        <h2 class="descripcion">¿Quiénes somos?</h2>
        <p class="descripcion">
          En Comidas Rápidas nos apasiona ofrecerte una experiencia única con las mejores opciones de comida rápida.
          Desde nuestras deliciosas hamburguesas hasta nuestras papas crujientes y bebidas, cada plato está hecho con los 
          ingredientes más frescos y de alta calidad para que disfrutes de una comida rápida, sabrosa y satisfactoria.
          <br><br>
          Nuestro objetivo es brindarte una opción deliciosa y conveniente para cualquier momento del día.
          Te invitamos a disfrutar de nuestros platillos en un ambiente cómodo y agradable, ideal para compartir con amigos, familia o simplemente para darte un gusto.
          <br><br>
          Nos enorgullece atenderte con rapidez, amabilidad y, por supuesto, ¡con un sabor inigualable que te hará volver!
          <br><br>
        </p>
      </div>
    </div>
  </section>

  <?php include '../includes/footer.php'; ?>

</body>

</html>