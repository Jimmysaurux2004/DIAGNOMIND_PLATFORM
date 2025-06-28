<?php
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/../../models/atencion.php';
require_once __DIR__ . '/../../models/paciente.php';

class GetHistorialAutoevaluaciones {
    public string $message = "";
    private $objAtencion;
    private $objPaciente;

    public function __construct() {
        $this->objAtencion = new Atencion();
        $this->objPaciente = new Paciente();
    }

    public function obtenerIdPacientePorDni(string $dni): ?int {
        return $this->objPaciente->obtenerIdPacientePorDni($dni);
    }

    public function obtenerHistorialPaciente(int $idPaciente): ?array {
        error_log('$idPaciente==>'.$idPaciente);
        $historial = $this->objAtencion->obtenerAtencionesYSintomasPorPaciente($idPaciente);

        if (!empty($historial)) {
            return $historial; // ✅ Arreglo de atenciones con sus síntomas
        } else {
            $this->message = "No se encontró historial de autoevaluaciones para el paciente.";
            return null;
        }
    }
}