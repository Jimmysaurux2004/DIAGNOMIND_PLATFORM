<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

class Paciente {

    public function obtenerIdPacientePorDni(string $dni): ?int {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return null;

        $sql = 'SELECT id FROM pacientes WHERE dni = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param("s", $dni);
        if (!$stmt->execute()) {
            $stmt->close();
            Conexion::desconectarBD();
            return null;
        }

        $id = null;
        $stmt->bind_result($id);
        $stmt->fetch();

        $stmt->close();
        Conexion::desconectarBD();

        return $id;
    }

}
