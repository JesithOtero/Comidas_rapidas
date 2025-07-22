<!-- Botón toggle solo visible en móviles -->
<button class="btn btn-primary d-md-none m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
    <i class="bi bi-list"></i> Menú
</button>

<!-- Sidebar: visible fijo en desktop, offcanvas en móvil -->
<nav id="sidebar" class="offcanvas-md offcanvas-start d-md-flex flex-column flex-shrink-0 p-3 text-white sidebar" tabindex="-1">
    <!-- Header solo visible en móviles -->
    <div class="offcanvas-header d-md-none">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>

    <!-- Cuerpo del sidebar -->
    <div class="offcanvas-body d-md-flex flex-column p-0 h-100">
        <!-- Usuario -->
        <div class="text-center mb-3">
            <div class="user-avatar">
                <i class="bi bi-person-circle fs-1"></i>
            </div>
            <div class="user-info">
                <p class="mb-0">
                 Usuario: <br>
                 <?php 
                    if (isset($usuario) && is_array($usuario)) {
                        echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']);
                    } else {
                        echo "Invitado";
                    }
                 ?>
                </p>
            </div>
        </div>

        <!-- Enlaces -->
        <ul class="nav flex-column flex-grow-1">
            <li class="nav-item">
                <a class="nav-link1 <?php echo basename($_SERVER['PHP_SELF']) == 'inicio.php' ? 'active' : ''; ?>" href="inicio.php">
                    <i class="bi bi-house-door"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link1 <?php echo strpos($_SERVER['REQUEST_URI'], 'clientes.php') !== false ? 'active' : ''; ?>" href="clientes.php">
                    <i class="bi bi-people"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link1 <?php echo strpos($_SERVER['REQUEST_URI'], 'mesa.php') !== false ? 'active' : ''; ?>" href="mesa.php">
                    <i class="fas fa-chair"></i> Mesa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link1 <?php echo strpos($_SERVER['REQUEST_URI'], 'comida.php') !== false ? 'active' : ''; ?>" href="comida.php">
                    <i class="bi bi-fork-knife"></i> Comida
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link1 <?php echo strpos($_SERVER['REQUEST_URI'], 'reservas.php') !== false ? 'active' : ''; ?>" href="reservas.php">
                    <i class="bi bi-calendar-check"></i> Reservas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link1 <?php echo strpos($_SERVER['REQUEST_URI'], 'pedido.php') !== false ? 'active' : ''; ?>" href="pedido.php">
                    <i class="bi bi-cart"></i> Pedidos
                </a>
            </li>
        </ul>

        <!-- Cerrar sesión -->
        <div class="mt-auto p-3">
            <a class="nav-link2" href="../../auth/logout.php">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </div>
    </div>
</nav>
