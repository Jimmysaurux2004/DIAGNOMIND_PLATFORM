<?php 
require_once __DIR__ . '/../../utils/log_config.php';
class formReporteGeneral{
    public function formReporteGeneralShow($reporte){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>REPORTE GENERAL</h1>
        <?php
        return ob_get_clean();
    }
}
?>