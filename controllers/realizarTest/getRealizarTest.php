<?php
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/../../models/sintoma.php';

class GetRealizarTest {
    public string $message = "";
    private Sintoma $objSintoma;

    public function __construct() {
        $this->objSintoma = new Sintoma();
    }

    public function obtenerSintomas(): array {
        return $this->objSintoma->obtenerSintomas();
    }

}
