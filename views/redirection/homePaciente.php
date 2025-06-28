<?php
require_once __DIR__ . '/../dashboard/homePaciente.php';
$panelPrincipalPaciente = new panelPrincipalPaciente();
session_start();

function validarSesion()
{
    if (!isset($_SESSION["usuario"], $_SESSION["datos"])) {
        return false;
    } else {
        return true;
    }
}

if (validarSesion()) {
    $panelPrincipalPaciente->panelPrincipalPacienteShow();
} else {
    header("Location: ../../index.php");
   exit();
}

?>