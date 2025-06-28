<?php
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/../../models/atencion.php';
require_once __DIR__ . '/../../models/atencionSintoma.php';
require_once __DIR__ . '/../../models/paciente.php';

class GetEvaluarDiagnostico {
    public string $message = "";
    private $objAtencion;
    private $objAtencionSintoma;
    private $objPaciente;

    public function __construct() {
        $this->objAtencion = new Atencion();
        $this->objAtencionSintoma = new AtencionSintoma();
        $this->objPaciente = new Paciente();
    }

    public function evaluarDiagnostico($paramLista) {
        $archivoProlog = "DiagnoMind.pl";

        if (!file_exists($archivoProlog)) {
            $this->message = "No se puede localizar el archivo del sistema experto ($archivoProlog). Verifique la instalación.";
            return null;
        }

        $paramLista = trim($paramLista);
        if (empty($paramLista)) {
            $this->message = "No se han seleccionado síntomas.";
            return null;
        }

        $sintomas = array_filter(explode(',', $paramLista), fn($s) => is_numeric($s));
        if (empty($sintomas)) {
            $this->message = "No se han seleccionado síntomas válidos.";
            return null;
        }

        $listaProlog = '[' . implode(',', $sintomas) . ']';
        $comando = "swipl -s $archivoProlog -g \"test($listaProlog).\" -t halt.";
        $resultado = shell_exec($comando);
        // Convertir salida binaria a UTF-8 con detección automática
        $resultado = mb_convert_encoding($resultado, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');

        if (empty(trim($resultado))) {
            $this->message = "No se pudo determinar un diagnóstico con los síntomas proporcionados.";
            return null;
        }
        error_log('VALOR DE $resultado==>'.$resultado);
        return trim($resultado);
    }

    public function obtenerIdPacientePorDni(string $dni): ?int {
        return $this->objPaciente->obtenerIdPacientePorDni($dni);
    }

    public function guardarAtencionYRespuestas(int $idPaciente, string $resultado, array $respuestas): bool {
        $idAtencion = $this->objAtencion->registrarAtencionPaciente($idPaciente, $resultado);
        if ($idAtencion === null) {
            $this->message = "No se pudo registrar la atención.";
            return false;
        }

        foreach ($respuestas as $index => $valor) {
            $respuesta = strtoupper($valor) === 'S' ? 'S' : 'N';
            $idSintoma = $index + 1;
            $ok = $this->objAtencionSintoma->registrarSintomaDeAtencion($idAtencion, $idSintoma, $respuesta);
            if (!$ok) {
                $this->message = "Error al registrar síntoma $idSintoma.";
                return false;
            }
        }

        return true;
    }
}
