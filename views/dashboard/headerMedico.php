<?php
class GetHeaderMedico {
    public function headerMedicoShow($nombre_usuario, $nombres, $apellidos, $colegiatura) {
        ?>
    <header class="d-flex flex-wrap justify-content-between align-items-center px-3">
        <!-- Botón de menú a la izquierda -->
        <div class="d-flex align-items-center">
            <button class="btn btn-toggle-menu" type="button" onclick="toggleMenu()">☰</button>
        </div>

        <!-- Área derecha: Usuario + OMS -->
        <div class="d-flex align-items-center">
            <!-- Dropdown usuario -->
            <div class="dropdown position-relative me-2">
                <button class="btn d-flex align-items-center" id="userDropdown" onclick="toggleUserMenu(event)">
                    <div class="profile-img me-2">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <span class="txt-span-header">Médico: <?= htmlspecialchars($nombre_usuario) ?></span>
                </button>

                <!-- Menú desplegable -->
                <div id="userMenu" class="user-menu">
                    <div class="text-center">
                        <div class="profile-img mx-auto">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <p class="mb-0"><?= htmlspecialchars($nombres . ' ' . $apellidos) ?></p>
                        <small class="text-muted">Colegiatura: <?= htmlspecialchars($colegiatura) ?></small>
                    </div>
                    <hr>
                    <a href="../../cerrarSesion.php" class="btn-cerrarSesion w-100" id="cerrarSesion">Cerrar Sesión</a>
                </div>
            </div>

            <!-- Botón OMS separado -->
            <a href="https://www.who.int/" target="_blank" class="btn btn-oms-link d-flex align-items-center">
                <i class="fas fa-globe-americas me-1"></i>
                <span class="txt-span-header">OMS</span>
            </a>
        </div>
    </header>
        <?php
    }
}
?>
