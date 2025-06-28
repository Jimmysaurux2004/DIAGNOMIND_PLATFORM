<?php
require_once __DIR__ . '/head.php';
require_once __DIR__ . '/menuMedico.php';
require_once __DIR__ . '/headerMedico.php';

class panelPrincipalMedico {

    public function panelPrincipalMedicoShow() {

        if (!isset($_SESSION['usuario']) || !isset($_SESSION['datos'])) {
            header("Location: ../../index.html");
            exit;
        }

        $usuario = $_SESSION['usuario'];
        $datos = $_SESSION['datos'];

        $getHead = new GetHead();
        $getMenu = new GetMenuMedico();
        $getHeader = new GetHeaderMedico();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <?php $getHead->headShow("home.css"); ?>
        <body onload="//initializeMenu()">
            <?php $getMenu->menuMedicoShow(); ?>

            <div class="main-content">
                <?php
                $getHeader->headerMedicoShow(
                    $usuario,
                    $datos['nombres'],
                    $datos['apellidos'],
                    $datos['numero_colegiatura']
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
            <script src="../../asset/js/homeMedico.js"></script>
        </body>
        </html>
        <?php
    }
}
