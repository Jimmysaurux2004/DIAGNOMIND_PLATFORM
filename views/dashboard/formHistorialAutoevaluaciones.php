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
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Diagnóstico</th>
                        <th>Ver Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($autoevaluaciones)): ?>
                        <?php foreach ($autoevaluaciones as $index => $eval): ?>
                            <tr>
                                <td class="text-center"><?= $index + 1 ?></td>
                                <td class="text-center"><?= $eval['fecha'] ?></td>
                                <td class="text-center"><?= $eval['hora'] ?></td>
                                <td class="text-center text-uppercase fw-bold text-primary"><?= $eval['resultado'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm text-white ha-ver-detalles"
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

        <!-- Modal -->
        <div class="modal fade" id="ha-modal-historial" tabindex="-1" aria-labelledby="ha-modalHistorialLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content ha-modal rounded-4 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ha-modalHistorialLabel">Detalle de Autoevaluación</h5>
                        <button type="button" class="btn-close" id="ha-modal-cerrar" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ha-modal-linea"><span class="ha-modal-label">📅 Fecha:</span> <span id="ha-modal-fecha"></span></div>
                        <div class="ha-modal-linea"><span class="ha-modal-label">🕒 Hora:</span> <span id="ha-modal-hora"></span></div>
                        <div class="ha-modal-linea"><span class="ha-modal-label">🧠 Diagnóstico:</span> <span id="ha-modal-diagnostico"></span></div>
                        <hr/>
                        <h6 class="ha-modal-subtitulo">Síntomas evaluados:</h6>
                        <ul class="ha-modal-lista" id="ha-modal-lista-sintomas"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../asset/js/historialAutoevaluaciones.js"></script>
    <link rel="stylesheet" href="../../asset/css/historialAutoevaluaciones.css">

<?php return ob_get_clean(); } }
?>
