<?php 
class GetMenuMedico {
    public function menuMedicoShow() {
        ?>
        <!-- Menú lateral DiagnoMind -->
        <div id="offcanvasScrolling" class="custom-offcanvas">

            <div class="container d-flex flex-column">
            <button type="button" class="menu-header d-flex align-items-center">
                <i class="fas fa-brain"></i><span class="logo-text">DIAGNOMIND</span>
            </button>
            </div>

            <hr class="separador-canva">

            <div class="container d-flex flex-column">
                <button type="button" class="menu-item" onclick="cargarVistaInicioMedico()">
                    <i class="fas fa-home"></i><span class="menu-text">Inicio</span>
                </button>

                <button type="button" class="menu-item" onclick="cargarFormularioMisPacientes()">
                    <i class="fas fa-user-injured"></i><span class="menu-text">Mis Pacientes</span>
                </button>

                <button type="button" class="menu-item" onclick="cargarFormularioReporteGeneral()">
                    <i class="fas fa-chart-pie"></i><span class="menu-text">Reporte General</span>
                </button>
            </div>

            <hr class="separador-canva">

            <div class="container d-flex flex-column">
                <a href="../../cerrarSesion.php" class="menu-item text-decoration-none">
                    <i class="fas fa-sign-out-alt"></i><span class="menu-text">Cerrar Sesión</span>
                </a>
            </div>
        </div>
        <?php
    }
}
?>
