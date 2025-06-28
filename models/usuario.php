<?php
declare(strict_types=1);
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

class Usuario {

    public function existeUsuario($usuario) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return false;

        $sql = 'SELECT 1 FROM usuarios WHERE usuario = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        $existe = $stmt->num_rows > 0;

        $stmt->close();
        Conexion::desconectarBD();

        return $existe;
    }

    public function fueEliminadoUsuario($usuario) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return false;

        $sql = 'SELECT estado FROM usuarios WHERE usuario = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $estado = null;
        $stmt->bind_result($estado);

        $eliminado = false;
        if ($stmt->fetch()) {
            if ($estado == '2') {
                $eliminado = true;
            }
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $eliminado;
    }

    public function fueInactivadoUsuario($usuario) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return false;

        $sql = 'SELECT estado FROM usuarios WHERE usuario = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $estado = null;
        $stmt->bind_result($estado);

        $inactivado = false;
        if ($stmt->fetch()) {
            if ($estado == '0') {
                $inactivado = true;
            }
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $inactivado;
    }

    public function verificarContrasenaCorrecta($usuario, $clave) {
        $conexion = Conexion::conectarBD();
    
        if (!$conexion) {
            return false; // No hacer echo aquí para evitar salida doble
        }
    
        $sql = 'SELECT clave FROM usuarios WHERE usuario = ? LIMIT 1';
        $stmt = $conexion->prepare($sql);
    
        if (!$stmt) {
            return false;
        }
    
        $stmt->bind_param("s", $usuario);
        if (!$stmt->execute()) {
            return false;
        }
    
        $hashedPassword = null;
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
    
        if ($hashedPassword === null) {
            return false;
        }

        $hashedPassword = trim($hashedPassword);
        $clave = trim($clave);
        return password_verify($clave, $hashedPassword); // Retorna true o false sin hacer echo
    }

    public function obtenerRolUsuario($usuario) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return null;

        $sql = 'SELECT rol FROM usuarios WHERE usuario = ? LIMIT 1';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param("s", $usuario);
        if (!$stmt->execute()) return null;

        $rol = null;
        $stmt->bind_result($rol);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();

        return $rol; // Puede ser 'medico', 'paciente' o null si no se encuentra
    }

    public function obtenerDatosAdicionales($usuario, $rol) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return null;

        // Consulta base para obtener el ID de usuario
        $sqlUsuario = "SELECT id FROM usuarios WHERE usuario = ? LIMIT 1";
        $stmt = $conexion->prepare($sqlUsuario);
        if (!$stmt) return null;

        $stmt->bind_param("s", $usuario);
        if (!$stmt->execute()) return null;

        $stmt->bind_result($idUsuario);
        if (!$stmt->fetch()) {
            $stmt->close();
            return null;
        }
        $stmt->close();

        // Dependiendo del rol, buscar en la tabla correspondiente
        if ($rol === "medico") {
            $sql = "SELECT nombres, apellidos, numero_colegiatura 
                    FROM medicos 
                    WHERE id_usuario = ? LIMIT 1";
        } elseif ($rol === "paciente") {
            $sql = "SELECT nombres, apellidos, dni 
                    FROM pacientes 
                    WHERE id_usuario = ? LIMIT 1";
        } else {
            return null;
        }

        $stmt = $conexion->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param("i", $idUsuario);
        if (!$stmt->execute()) return null;

        if ($rol === "medico") {
            $stmt->bind_result($nombres, $apellidos, $colegiatura);
            if ($stmt->fetch()) {
                $stmt->close();
                Conexion::desconectarBD();
                return [
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'numero_colegiatura' => $colegiatura
                ];
            }
        } elseif ($rol === "paciente") {
            $stmt->bind_result($nombres, $apellidos, $dni);
            if ($stmt->fetch()) {
                $stmt->close();
                Conexion::desconectarBD();
                return [
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'dni' => $dni
                ];
            }
        }

        $stmt->close();
        Conexion::desconectarBD();
        return null;
    }


}
