<?php
session_start();
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

header('Content-Type: application/json');

$conn = Conexion::conectarBD();

// Validar que haya sesión iniciada con número de dni
if (!isset($_SESSION['datos']['dni'])) {
    error_log('[Sesion] No se encontró número de DNI en $_SESSION');
    session_destroy();
    echo json_encode(['status' => 'no_session']);
    exit;
}

$dni = $_SESSION['datos']['dni'];

// Obtener el id_usuario desde la tabla pacientes
$sql = "SELECT u.estado 
        FROM pacientes p 
        INNER JOIN usuarios u ON p.id_usuario = u.id 
        WHERE p.dni = ? 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    switch ($row['estado']) {
        case 0:
            error_log('[Sesion] Usuario paciente inactivo');
            session_destroy();
            echo json_encode(['status' => 'inactive']);
            break;

        case 1:
            echo json_encode(['status' => 'active']);
            break;

        case 2:
            error_log('[Sesion] Usuario paciente eliminado');
            session_destroy();
            echo json_encode(['status' => 'deleted']);
            break;

        default:
            error_log('[Sesion] Estado desconocido en tabla usuarios');
            session_destroy();
            echo json_encode(['status' => 'error']);
            break;
    }
} else {
    error_log("[Sesion] No se encontró el paciente con dni: $dni");
    session_destroy();
    echo json_encode(['status' => 'not_found']);
    exit;
}
