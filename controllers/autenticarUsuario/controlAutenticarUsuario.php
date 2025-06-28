<?php
session_start();

require_once __DIR__ . '/getAutenticarUsuario.php';
require_once __DIR__ . '/../../utils/log_config.php';

error_log("POST recibido: " . print_r($_POST, true));

$getAutenticarUsuario = new GetAutenticarUsuario();

if ($getAutenticarUsuario->validarBoton("btnLogin")) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $metodoIngreso = $_POST['btnLogin'];
    if($getAutenticarUsuario->validarCampoUsuario($usuario)){
        if($getAutenticarUsuario->existeUsuario($usuario)){
            if(!($getAutenticarUsuario->usuarioEliminado($usuario))){
                if(!($getAutenticarUsuario->usuarioInactivado($usuario))){
                    if($getAutenticarUsuario->validarCampoContrasena($contrasena)){
                        if($getAutenticarUsuario->verificarContrasenaCorrecta($usuario, $contrasena)){
                            if($rol = $getAutenticarUsuario->verificarMetodoIngreso($usuario, $metodoIngreso)){
                                $datos = $getAutenticarUsuario->obtenerDatosAdicionales($usuario, $rol);
                                $_SESSION['usuario'] = $usuario;
                                $_SESSION['datos'] = $datos;
                                error_log("DATOS SESSION: " . print_r($_SESSION, true));
                                $vista = ($rol === 'medico') 
                                    ? "views/redirection/homeMedico.php"
                                    : "views/redirection/homePaciente.php";
                                echo json_encode([
                                    'flag' => 1,
                                    'message' => "Inicio de sesión exitoso",
                                    'redirect' => $vista
                                ]);
                            }else{
                                echo json_encode([
                                    'flag' => 0,
                                    'message' => $getAutenticarUsuario->message
                                ]);  
                            }
                        }else{
                            echo json_encode([
                                'flag' => 0,
                                'message' => $getAutenticarUsuario->message
                            ]);  
                        }
                    }else{
                        echo json_encode([
                            'flag' => 0,
                            'message' => $getAutenticarUsuario->message
                        ]);  
                    }
                }else{
                    echo json_encode([
                        'flag' => 0,
                        'message' => $getAutenticarAdministrador->message
                    ]);  
                }
            }else{
                echo json_encode([
                    'flag' => 0,
                    'message' => $getAutenticarUsuario->message
                ]);  
            }
        }else{
            echo json_encode([
                'flag' => 0,
                'message' => $getAutenticarUsuario->message
            ]);
        }
    }else{
         echo json_encode([
            'flag' => 0,
            'message' => $getAutenticarUsuario->message
        ]);  
    }
} else {
    echo json_encode([
        'flag' => 0,
        'message' => "No se presionó el botón de login o solicitud inválida",
        'redirect' => null
    ]);
}
?>