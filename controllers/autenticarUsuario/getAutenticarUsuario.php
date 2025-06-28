<?php
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/../../models/usuario.php';

class GetAutenticarUsuario {
    public string $message = "";
    private $objUsuario;

    public function __construct() {
        $this->objUsuario = new Usuario();
    }

    public function validarBoton($nombreBoton) {
        $valoresPermitidos = ["AccederComoMedico", "AccederComoPaciente"];
        if (isset($_POST[$nombreBoton]) && in_array($_POST[$nombreBoton], $valoresPermitidos, true)) {
            return true;
        } else {
            $this->message = "Debe seleccionar un método válido de acceso.";
            return false;
        }
    }

    public function existeUsuario($usuario) {
        if ($this->objUsuario->existeUsuario($usuario)) {
            return true;
        } else {
            $this->message = "El usuario ingresado no existe. Verifique sus datos e intente nuevamente.";
            return false;
        }
    }

    public function validarCampoUsuario($usuario) {
        $usuario = trim($usuario);

        if (empty($usuario)) {
            $this->message = "El campo de usuario no puede estar vacío.";
            return false;
        }

        return true;
    }

    // Verificar si el usuario fue eliminado de la base de datos
    public function usuarioEliminado($usuario) {
        if ($this->objUsuario->fueEliminadoUsuario($usuario)) {
            $this->message = "Acceso denegado. El usuario fue eliminado del sistema";
            return true;
        } else {
            return false;
        }
    }

    // Verificar si el administrador fue inactivado de la base de datos
    public function usuarioInactivado($usuario) {
        if ($this->objUsuario->fueInactivadoUsuario($usuario)) {
            $this->message = "Acceso denegado. El usuario fue inactivado temporalmente del sistema";
            return true;
        } else {
            return false;
        }
    }

    // Validar la seguridad de la contraseña (mínimo 4 caracteres)
    public function validarCampoContrasena($contrasena) {
        $contrasena = trim($contrasena);
        
        if (empty($contrasena)) {
            $this->message = "El campo de contraseña no puede estar vacío.";
            return false;
        }

        if (strlen($contrasena) < 4) {
            $this->message = "La contraseña debe tener al menos 4 caracteres.";
            return false;
        }

        return true;
    }

    // Validar la contraseña del usuario en la base de datos
    public function verificarContrasenaCorrecta($usuario, $contrasena) {
        if ($this->objUsuario->verificarContrasenaCorrecta($usuario, $contrasena)) {
            return true;
        } else {
            $this->message = "La contraseña ingresada es incorrecta. Intente nuevamente.";
            return false;
        }
    }

    // Validar el rol del usuario en la base de datos
    public function obtenerRolUsuario($usuario) {
        $rol = $this->objUsuario->obtenerRolUsuario($usuario);
        if ($rol !== null) {
            return $rol; // 'medico' o 'paciente'
        } else {
            $this->message = "El usuario no posee ningún rol definido.";
            return null;
        }
    }

    public function verificarMetodoIngreso($usuario, $metodoIngreso) {
        $rol = $this->obtenerRolUsuario($usuario);

        if ($rol === null) {
            $this->message = "El usuario no posee ningún rol definido.";
            return false;
        }

        if ($metodoIngreso === "AccederComoMedico" && $rol !== "medico") {
            $this->message = "Médico no encontrado en el sistema.";
            return false;
        }

        if ($metodoIngreso === "AccederComoPaciente" && $rol !== "paciente") {
            $this->message = "Paciente no encontrado en el sistema.";
            return false;
        }

        // Método de ingreso coincide con el rol
        return $rol;
    }

    public function obtenerDatosAdicionales($usuario, $rol) {
        $datosUsuario = $this->objUsuario->obtenerDatosAdicionales($usuario, $rol);
        if ($datosUsuario !== null) {
            return $datosUsuario; // Retorna los datos adicionales según el rol
        } else {
            $this->message = "No se puedieron obtener los datos adicionales del usuario.";
            return null;
        }
    }
}
