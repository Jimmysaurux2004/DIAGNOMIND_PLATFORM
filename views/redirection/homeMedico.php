<?php
require_once __DIR__ . '/../dashboard/homeMedico.php';
$panelPrincipalMedico = new panelPrincipalMedico();
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
    $panelPrincipalMedico->panelPrincipalMedicoShow();
} else {
    header("Location: ../../index.php");
   exit();
}

?>