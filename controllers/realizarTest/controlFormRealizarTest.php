<?php 
require_once __DIR__ . '/../../views/dashboard/formRealizarTest.php';
require_once __DIR__ . '/getRealizarTest.php';

$formRealizarTest = new formRealizarTest;
$getRealizarTest = new GetRealizarTest();
$sintomas = $getRealizarTest->obtenerSintomas();
$soloPreguntas = array_column($sintomas, 'pregunta');

$formulario = $formRealizarTest->formRealizarTestShow($soloPreguntas);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);

?>