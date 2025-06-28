<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

class Atencion {

    public function registrarAtencionPaciente(int $idPaciente, string $resultado): ?int {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return null;

        try {
            $conexion->begin_transaction();

            // Establecer zona horaria para Perú
            date_default_timezone_set('America/Lima');

            $fecha = date('Y-m-d');
            $hora = date('H:i:s');

            $sql = "INSERT INTO atenciones (id_paciente, fecha, hora, resultado)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparando INSERT en atenciones: " . $conexion->error);
            }

            $stmt->bind_param("isss", $idPaciente, $fecha, $hora, $resultado);
            $stmt->execute();

            $idGenerado = $stmt->insert_id;

            $conexion->commit();
            return $idGenerado;
        } catch (Exception $e) {
            $conexion->rollback();
            error_log("Error al registrar atención: " . $e->getMessage());
            return null;
        } finally {
            if (isset($stmt)) $stmt->close();
            Conexion::desconectarBD();
        }
    }

    public function obtenerAtencionesYSintomasPorPaciente(int $idPaciente): array {
        $conexion = Conexion::conectarBD();
        $resultadoFinal = [];

        try {
            // 1. Obtener todas las atenciones del paciente
            $sqlAtenciones = "SELECT id, fecha, hora, resultado
                            FROM atenciones
                            WHERE id_paciente = ?
                            ORDER BY fecha DESC, hora DESC";
            $stmtAtenciones = $conexion->prepare($sqlAtenciones);
            $stmtAtenciones->bind_param("i", $idPaciente);
            $stmtAtenciones->execute();
            $resAtenciones = $stmtAtenciones->get_result();

            while ($atencion = $resAtenciones->fetch_assoc()) {
                $idAtencion = $atencion['id'];

                // 2. Obtener los síntomas asociados a esa atención
                $sqlSintomas = "SELECT ats.id_sintoma, s.descripcion, ats.respuesta
                                FROM atencion_sintomas ats
                                INNER JOIN sintomas s ON ats.id_sintoma = s.id
                                WHERE ats.id_atencion = ?";
                $stmtSintomas = $conexion->prepare($sqlSintomas);
                $stmtSintomas->bind_param("i", $idAtencion);
                $stmtSintomas->execute();
                $resSintomas = $stmtSintomas->get_result();

                $sintomas = [];
                while ($sintoma = $resSintomas->fetch_assoc()) {
                    $sintomas[] = [
                        'id_sintoma' => $sintoma['id_sintoma'],
                        'descripcion' => $sintoma['descripcion'],
                        'respuesta' => $sintoma['respuesta']
                    ];
                }

                // 3. Armar estructura final por atención
                $resultadoFinal[] = [
                    'id_atencion' => $idAtencion,
                    'fecha' => $atencion['fecha'],
                    'hora' => $atencion['hora'],
                    'resultado' => $atencion['resultado'],
                    'sintomas' => $sintomas
                ];

                $stmtSintomas->close(); // Cerrar después de cada ejecución
            }

            $stmtAtenciones->close();
        } catch (Exception $e) {
            error_log("Error al obtener atenciones y síntomas: " . $e->getMessage());
            return [];
        } finally {
            Conexion::desconectarBD();
        }

        return $resultadoFinal;
    }

}
