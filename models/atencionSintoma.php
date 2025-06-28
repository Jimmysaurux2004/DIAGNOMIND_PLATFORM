<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

class AtencionSintoma {

    public function registrarSintomaDeAtencion(int $idAtencion, int $idSintoma, string $respuesta): bool {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return false;

        try {
            $conexion->begin_transaction();

            $sql = "INSERT INTO atencion_sintomas (id_atencion, id_sintoma, respuesta)
                    VALUES (?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparando INSERT en atencion_sintomas: " . $conexion->error);
            }

            $stmt->bind_param("iis", $idAtencion, $idSintoma, $respuesta);
            $stmt->execute();

            $conexion->commit();
            return true;
        } catch (Exception $e) {
            $conexion->rollback();
            error_log("Error al registrar síntoma: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) $stmt->close();
            Conexion::desconectarBD();
        }
    }

}
