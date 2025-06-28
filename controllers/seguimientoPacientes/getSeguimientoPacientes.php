<?php
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/../../models/atencion.php';
require_once __DIR__ . '/../../models/paciente.php';

class GetSeguimientoPacientes {
    public string $message = "";
    private $objAtencion;
    private $objPaciente;

    public function __construct() {
        $this->objAtencion = new Atencion();
        $this->objPaciente = new Paciente();
    }

    public function obtenerTodosLosIdDePacientes(): ?array {
        return $this->objPaciente->obtenerTodosLosIdDePacientes();
    }

    public function obtenerHistorialPaciente(int $idPaciente): ?array {
        $historial = $this->objAtencion->obtenerAtencionesYSintomasPorPaciente($idPaciente);

        if (!empty($historial)) {
            return $historial; // ✅ Arreglo de atenciones con sus síntomas
        } else {
            $this->message = "No se encontró historial de autoevaluaciones para el paciente.";
            return null;
        }
    }

    public function obtenerDatosCompletosPaciente(int $idPaciente): ?array {
        $datos = $this->objPaciente->obtenerDatosPacientePorId($idPaciente);

        if (!empty($datos)) {
            return $datos; // ✅ Retorna todos los campos del paciente
        } else {
            $this->message = "No se encontraron datos para el paciente con ID $idPaciente.";
            return null;
        }
    }

}