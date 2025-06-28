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

    public function obtenerTodosLosIdDePacientes(): array {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return [];

        $sql = 'SELECT id FROM pacientes;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            Conexion::desconectarBD();
            return [];
        }

        if (!$stmt->execute()) {
            $stmt->close();
            Conexion::desconectarBD();
            return [];
        }

        $result = $stmt->get_result();
        $ids = [];

        while ($fila = $result->fetch_assoc()) {
            $ids[] = (int)$fila['id'];
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $ids;
    }

    public function obtenerDatosPacientePorId(int $idPaciente): ?array {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return null;

        $sql = 'SELECT * FROM pacientes WHERE id = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            Conexion::desconectarBD();
            return null;
        }

        $stmt->bind_param("i", $idPaciente);

        if (!$stmt->execute()) {
            $stmt->close();
            Conexion::desconectarBD();
            return null;
        }

        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();

        $stmt->close();
        Conexion::desconectarBD();

        return $datos ?: null;
    }

}
