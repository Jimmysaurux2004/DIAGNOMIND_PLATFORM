<?php 
class GetMenuPaciente {
    public function menuPacienteShow() {
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
                <button type="button" class="menu-item" onclick="cargarVistaInicioPaciente()">
                    <i class="fas fa-home"></i><span class="menu-text">Inicio</span>
                </button>

                <button type="button" class="menu-item" onclick="cargarFormularioRealizarTest()">
                    <i class="fas fa-user-injured"></i><span class="menu-text">Realizar Test</span>
                </button>

                <button type="button" class="menu-item" onclick="cargarFormularioHistorialAutoevaluaciones()">
                    <i class="fas fa-user-injured"></i><span class="menu-text">Mi Historial Médico</span>
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
