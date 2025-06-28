<?php
require_once __DIR__ . '/../../utils/log_config.php';

class formHistorialAutoevaluaciones {
    public function formHistorialAutoevaluacionesShow($autoevaluaciones) {
        ob_start(); ?>
        
    <div class="ha-container container mb-5">
        <h3 class="ha-titulo mb-4 border-bottom pb-2 text-dark">HISTORIAL DE AUTOEVALUACIONES</h3>

        <!-- Control de cantidad y navegación -->
        <div class="ha-controles d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div class="d-flex align-items-center">
                <label for="ha-items-por-pagina" class="form-text m-0 me-2">Mostrar:</label>
                <select id="ha-items-por-pagina" class="form-select w-auto">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span id="ha-total-registros" class="ms-1 form-text">registros</span>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary" id="ha-pagina-anterior">Anterior</button>
                <button class="btn btn-outline-secondary" id="ha-pagina-siguiente">Siguiente</button>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="ha-tabla-autoevaluaciones">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Intento N°</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Diagnóstico</th>
                        <th>Ver Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($autoevaluaciones)): ?>
                        <?php foreach (array_reverse($autoevaluaciones) as $index => $eval): ?>
                            <tr>
                                <td class="text-center"><?= count($autoevaluaciones) - $index ?></td>
                                <td class="text-center"><?= $eval['fecha'] ?></td>
                                <td class="text-center"><?= $eval['hora'] ?></td>
                                <td class="text-center text-uppercase fw-bold text-primary"><?= $eval['resultado'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm text-white ha-ver-detalles"
                                            style="background-color: #37474F; border: none;"
                                            data-fecha="<?= $eval['fecha'] ?>"
                                            data-hora="<?= $eval['hora'] ?>"
                                            data-diagnostico="<?= $eval['resultado'] ?>"
                                            data-sintomas='<?= htmlspecialchars(json_encode($eval['sintomas']), ENT_QUOTES, 'UTF-8') ?>'>
                                        <i class="fas fa-eye"></i> Ver
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted fst-italic">No hay autoevaluaciones registradas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal Moderno -->
        <div class="ha-modal" id="ha-modal-detalle-autoevaluacion" style="display: none;">
        <div class="ha-modal-contenido rounded-4 shadow">
            <span class="ha-modal-cerrar" id="ha-modal-cerrar">&times;</span>

            <div class="ha-modal-header">
            <h4 class="ha-modal-titulo " style="font-weight: bold;">Detalle de Autoevaluación</h4>
            </div>

            <div class="ha-modal-info">
            <div class="ha-divisor"></div> <!-- Línea arriba -->

            <p><strong>📅 Fecha:</strong> <span id="ha-modal-fecha">---</span></p>
            <p><strong>🕒 Hora:</strong> <span id="ha-modal-hora">---</span></p>
            <p><strong>🧠 Diagnóstico:</strong> <span id="ha-modal-diagnostico">---</span></p>

            <div class="ha-divisor"></div> <!-- Línea abajo -->
            </div>

            <div class="ha-modal-sintomas mb-2">
            <h5 style="font-weight: bold;">Síntomas evaluados:</h5>
            <ul id="ha-modal-lista-sintomas" class="ha-lista-sintomas ps-3"></ul>
            </div>
        </div>
        </div>

    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../../asset/js/historialAutoevaluaciones.js"></script>
    <link rel="stylesheet" href="../../asset/css/historialAutoevaluaciones.css">

<?php return ob_get_clean(); } }
?>
