<?php 
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/../../views/dashboard/formSeguimientoPacientes.php';
require_once __DIR__ . '/getSeguimientoPacientes.php';

$formSeguimientoPacientes = new formSeguimientoPacientes;
$getSeguimientoPacientes = new GetSeguimientoPacientes();

// Obtener todos los IDs de pacientes
$idsPacientes = $getSeguimientoPacientes->obtenerTodosLosIdDePacientes();

$pacientes = [];

// Recorrer cada ID y obtener su historial y datos personales
foreach ($idsPacientes as $id) {
    $historial = $getSeguimientoPacientes->obtenerHistorialPaciente($id);
    $datosPaciente = $getSeguimientoPacientes->obtenerDatosCompletosPaciente($id);

    if ($historial !== null && $datosPaciente !== null) {
        $pacientes[] = [
            'datos' => $datosPaciente,    // Todos los campos del paciente (incluye ID, nombres, apellidos, etc.)
            'historial' => $historial
        ];
    }
}

$formulario = $formSeguimientoPacientes->formSeguimientoPacientesShow($pacientes);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);
