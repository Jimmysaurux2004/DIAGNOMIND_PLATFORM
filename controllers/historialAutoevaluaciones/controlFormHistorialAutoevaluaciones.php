<?php
session_start();
require_once __DIR__ . '/../../views/dashboard/formHistorialAutoevaluaciones.php';
require_once __DIR__ . '/getHistorialAutoevaluaciones.php';
error_log("SESSION recibido: " . print_r($_SESSION, true));

// Obtener DNI desde sesión correctamente
$dni = $_SESSION['datos']['dni'] ?? null;
$formHistorialAutoevaluaciones = new formHistorialAutoevaluaciones;
$getHistorialAutoevaluaciones = new GetHistorialAutoevaluaciones();
$idPaciente = $getHistorialAutoevaluaciones->obtenerIdPacientePorDni($dni);
$autoevaluaciones = $getHistorialAutoevaluaciones->obtenerHistorialPaciente($idPaciente);
error_log('$autoevaluaciones==>'.print_r($autoevaluaciones,true));
$formulario = $formHistorialAutoevaluaciones->formHistorialAutoevaluacionesShow($autoevaluaciones);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);

?>