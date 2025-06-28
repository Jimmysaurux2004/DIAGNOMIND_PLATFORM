<?php
session_start();

require_once __DIR__ . '/getEvaluarDiagnostico.php';
require_once __DIR__ . '/../../utils/log_config.php';

error_log("POST recibido: " . print_r($_POST, true));
$param_lista = $_POST['param_lista'] ?? '';
$dni = $_SESSION['datos']['dni'];

$getEvaluarDiagnostico = new GetEvaluarDiagnostico();

// Convertir la lista de IDs en array de enteros
$idsSintomasS = array_filter(explode(',', $param_lista), fn($v) => is_numeric($v));
$idsSintomasS = array_map('intval', $idsSintomasS);

// Inicializar las 18 respuestas en 'N'
$respuestas = array_fill(0, 18, 'N');

// Colocar 'S' en las posiciones correspondientes
foreach ($idsSintomasS as $id) {
    if ($id >= 1 && $id <= 18) {
        $respuestas[$id - 1] = 'S'; // El ID 1 va en posición 0
    }
}

if($resultado = $getEvaluarDiagnostico->evaluarDiagnostico($param_lista)){
    if($idPaciente = $getEvaluarDiagnostico->obtenerIdPacientePorDni($dni)){
        if($getEvaluarDiagnostico->guardarAtencionYRespuestas($idPaciente, $resultado, $respuestas)){
            if ($resultado !== null) {
                echo trim($resultado); 
            } else {
                echo "No se pudo determinar un diagnóstico.";
            }
        }else{
            echo json_encode([
                'flag' => 0,
                'message' => $getAutenticarUsuario->message
            ]);  
        }
    }else{
        echo json_encode([
            'flag' => 0,
            'message' => $getAutenticarUsuario->message
        ]);  
    }
}else{
    echo json_encode([
        'flag' => 0,
        'message' => $getAutenticarUsuario->message
    ]);  
}



?>