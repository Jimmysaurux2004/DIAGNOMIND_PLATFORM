<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

class Sintoma {

    public function obtenerSintomas(): array {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return [];

        $sql = 'SELECT id, descripcion, pregunta FROM sintomas WHERE estado = "activo" ORDER BY id ASC;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return [];

        $stmt->execute();
        $resultado = $stmt->get_result();

        $sintomas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $sintomas[] = [
                'id' => (int) $fila['id'],
                'descripcion' => $fila['descripcion'],
                'pregunta' => $fila['pregunta']
            ];
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $sintomas;
    }

}
