<?php
session_start();
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

header('Content-Type: application/json');

$conn = Conexion::conectarBD();

// Validar que haya sesión iniciada con número de colegiatura
if (!isset($_SESSION['datos']['numero_colegiatura'])) {
    error_log('[Sesion] No se encontró número de colegiatura en $_SESSION');
    session_destroy();
    echo json_encode(['status' => 'no_session']);
    exit;
}

$colegiatura = $_SESSION['datos']['numero_colegiatura'];

// Obtener el id_usuario desde la tabla medicos
$sql = "SELECT u.estado 
        FROM medicos m 
        INNER JOIN usuarios u ON m.id_usuario = u.id 
        WHERE m.numero_colegiatura = ? 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $colegiatura);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    switch ($row['estado']) {
        case 0:
            error_log('[Sesion] Usuario médico inactivo');
            session_destroy();
            echo json_encode(['status' => 'inactive']);
            break;

        case 1:
            echo json_encode(['status' => 'active']);
            break;

        case 2:
            error_log('[Sesion] Usuario médico eliminado');
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
    error_log("[Sesion] No se encontró el médico con colegiatura: $colegiatura");
    session_destroy();
    echo json_encode(['status' => 'not_found']);
    exit;
}
