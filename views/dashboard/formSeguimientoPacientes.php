<?php 
require_once __DIR__ . '/../../utils/log_config.php';
class formSeguimientoPacientes{
    public function formSeguimientoPacientesShow($pacientes){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>SEGUIMIENTO DE PACIENTES</h1>
        <?php
        return ob_get_clean();
    }
}
?>