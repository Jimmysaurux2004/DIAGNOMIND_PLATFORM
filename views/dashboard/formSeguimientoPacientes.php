<?php 
require_once __DIR__ . '/../../utils/log_config.php';
class formSeguimientoPacientes{
    public function formSeguimientoPacientesShow($pacientes){
        ob_start();
        ?>
<div class="sp-container">
  <h2 class="sp-titulo">Mis pacientes</h2>

  <?php $total = count($pacientes); ?>
    <div class="sp-alerta-pacientes">
    <i class="fas fa-user-injured"></i>
    Usted cuenta con <strong><?= $total ?></strong> paciente<?= $total === 1 ? '' : 's' ?> inscrito<?= $total === 1 ? '' : 's' ?> en el sistema.
    </div>

  <div class="sp-lista-pacientes">
    <?php foreach ($pacientes as $paciente): ?>
      <div class="sp-card-paciente">
        <div class="sp-info-basica">
          <p class="sp-nombre"><strong><?= $paciente['datos']['nombres'] . ' ' . $paciente['datos']['apellidos'] ?></strong></p>
          <p>DNI: <?= $paciente['datos']['dni'] ?></p>
          <p>Registrado: <?= $paciente['datos']['fecha_registro'] ?> <?= $paciente['datos']['hora_registro'] ?></p>
          <p>Intentos: <?= count($paciente['historial']) ?></p>
        </div>
        <button class="sp-btn-detalle" data-paciente='<?= htmlspecialchars(json_encode($paciente), ENT_QUOTES, 'UTF-8') ?>'>
          <i class="fas fa-notes-medical"></i> Ver detalles
        </button>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Modal Detalle del Paciente -->
<div class="sp-modal" id="sp-modal-detalle-paciente">
  <div class="sp-modal-contenido">
    <span class="sp-cerrar" data-close="sp-modal-detalle-paciente">&times;</span>
    <h3 class="sp-modal-titulo">Historial del paciente</h3>

    <div class="sp-datos-paciente"></div>

    <div class="sp-tabla-wrapper">
      <table class="sp-tabla">
        <thead>
          <tr>
            <th>Intento Nº</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Resultado</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody id="sp-tabla-intentos"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Ver Síntomas -->
<div class="sp-modal" id="sp-modal-detalle-sintomas">
  <div class="sp-modal-contenido">
    <span class="sp-cerrar" data-close="sp-modal-detalle-sintomas">&times;</span>

    <div class="sp-modal-header">
      <h3 class="sp-modal-titulo">Detalle de Autoevaluación</h3>
    </div>

    <div class="sp-meta-info">
      <p><strong>📅 Fecha:</strong> <span id="sp-detalle-fecha">---</span></p>
      <p><strong>⏰ Hora:</strong> <span id="sp-detalle-hora">---</span></p>
      <p><strong>🧠 Diagnóstico:</strong> <span id="sp-detalle-diagnostico">---</span></p>
    </div>

    <div class="sp-sintomas-wrapper">
      <h4 class="sp-subtitulo-sintomas">Síntomas evaluados:</h4>
      <ul class="sp-lista-sintomas" id="sp-lista-sintomas"></ul>
    </div>
  </div>
</div>


<script src="../../asset/js/seguimientoPacientes.js"></script>
<link rel="stylesheet" href="../../asset/css/seguimientoPacientes.css">
        <?php
        return ob_get_clean();
    }
}
?>