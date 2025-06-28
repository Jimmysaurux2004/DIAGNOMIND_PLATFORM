<?php 
require_once __DIR__ . '/../../views/dashboard/formReporteGeneral.php';
require_once __DIR__ . '/getReporteGeneral.php';

$formReporteGeneral = new formReporteGeneral;
//$getSeguimientoPacientes = new GetSeguimientoPacientes();
//$pacientes = $getSeguimientoPacientes->obtenerInformacionDePacientes();
$reportes = [];
$formulario = $formReporteGeneral->formReporteGeneralShow($reportes);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);

?>