<?php 
require_once __DIR__ . '/../../views/dashboard/formSeguimientoPacientes.php';
require_once __DIR__ . '/getSeguimientoPacientes.php';

$formSeguimientoPacientes = new formSeguimientoPacientes;
//$getSeguimientoPacientes = new GetSeguimientoPacientes();
//$pacientes = $getSeguimientoPacientes->obtenerInformacionDePacientes();
$pacientes = [];
$formulario = $formSeguimientoPacientes->formSeguimientoPacientesShow($pacientes);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);

?>