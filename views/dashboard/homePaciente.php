<?php
require_once __DIR__ . '/head.php';
require_once __DIR__ . '/menuPaciente.php';
require_once __DIR__ . '/headerPaciente.php';

class panelPrincipalPaciente {

    public function panelPrincipalPacienteShow() {

        if (!isset($_SESSION['usuario']) || !isset($_SESSION['datos'])) {
            header("Location: ../../index.html");
            exit;
        }

        $usuario = $_SESSION['usuario'];
        $datos = $_SESSION['datos'];

        $getHead = new GetHead();
        $getMenu = new GetMenuPaciente();
        $getHeader = new GetHeaderPaciente();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <?php $getHead->headShow("home.css"); ?>
        <body onload="//initializeMenu()">
            <?php $getMenu->menuPacienteShow(); ?>

            <div class="main-content">
                <?php
                $getHeader->headerPacienteShow(
                    $usuario,
                    $datos['nombres'],
                    $datos['apellidos'],
                    $datos['dni']
                );
                ?>
                <div class="container mt-4 container-dinamico" id="contenido-dinamico">
                    <!-- Aquí se cargará el contenido dinámico del médico -->
                </div>
            </div>

            <!-- Scripts JS -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="../../asset/js/menu.js"></script>
            <script src="../../asset/js/homePaciente.js"></script>
        </body>
        </html>
        <?php
    }
}
