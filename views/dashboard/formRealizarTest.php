<?php
require_once __DIR__ . '/../../utils/log_config.php';
class formRealizarTest {
    public function formRealizarTestShow($sintomas) {
        ob_start();
        ?>
        <div class="cuestionario-container">
            <div class="intro-section" id="intro-section">
                <h2 class="titulo-test">Evaluación de Síntomas</h2>
                <p class="descripcion-test">
                    Seleccione los síntomas que haya experimentado recientemente. Esta autoevaluación no sustituye una consulta médica,
                    pero puede servir como una guía inicial para entender su estado emocional.
                </p>
                <button id="btnIniciar" class="btn-iniciar">Iniciar Test</button>
            </div>

            <div class="test-section" id="test-section" style="display:none;">
                <div class="progreso">
                    <div class="progress-wrapper">
                        <div class="progress-bar" id="barra-progreso"></div>
                    </div>
                    <div class="progreso-info">
                        <span id="contador-pregunta"></span>
                        <span> | </span>
                        <span id="resumen-respuestas"></span>
                    </div>
                </div>
                
                <div class="test-card" id="card-pregunta">
                    <p id="texto-sintoma"></p>
                    <div class="opciones">
                        <button class="btn-si" id="btn-si" onclick="responder('s')">
                        <i class="fas fa-check-circle"></i> Sí
                        </button>
                        <button class="btn-no" id="btn-no" onclick="responder('n')">
                        <i class="fas fa-times-circle"></i> No
                        </button>
                    </div>
                    <div id="mensaje-alerta" style="color: #D9534F; margin-top: 10px; font-weight: 500;"></div>
                    <div class="navegacion-test">
                        <button class="btn-nav flecha-izquierda" onclick="retrocederPregunta()">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <button class="btn-nav flecha-derecha" onclick="avanzarPregunta()">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="evaluacion-final" id="evaluacion-final" style="display:none;">
                    <button class="btn-evaluar" onclick="evaluarDiagnostico()">Evaluar Diagnóstico</button>
                    <input type="text" id="resultado-final" class="resultado" placeholder="Resultado..." readonly>
                    <button class="btn-intentar" onclick="reiniciarTest()">Intentar de Nuevo</button>
                </div>
            </div>
        </div>

        <script>
            const SINTOMAS = <?php echo json_encode($sintomas); ?>;
        </script>

        <!-- Tu archivo JavaScript personalizado -->
        <script src="../../asset/js/realizarTest.js"></script>
        <link rel="stylesheet" href="../../asset/css/realizarTest.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <?php
        return ob_get_clean();
    }
}