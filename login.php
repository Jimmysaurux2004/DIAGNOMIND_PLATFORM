<?php
session_start();
if (isset($_SESSION['usuario'])) {
    session_destroy(); // Salida segura si alguien ya había iniciado sesión
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar Sesión - DiagnoMind</title>
  <link rel="stylesheet" href="asset/css/bootstrap-5.3.3/css/bootstrap.min.css" />
  <link rel="stylesheet" href="asset/css/fontawesome-6/css/all.min.css" />
  <link rel="stylesheet" href="asset/css/login.css" />
  <script src="asset/css/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light tema-background">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 card-container" style="width: 450px;">

      <!-- Encabezado -->
      <div class="text-center mb-4">
        <h2 class="txt-titulo"><i class="fa-solid fa-brain"></i> DiagnoMind</h2>
        <p class="text-muted">Sistema experto para diagnóstico psicológico</p>
      </div>

      <!-- Selector de formulario -->
      <div class="nav nav-pills nav-justified mb-4">
        <button class="nav-link active rounded-pill bg-dark text-white" onclick="mostrarFormularioPaciente()">Paciente</button>
        <button class="nav-link rounded-pill bg-light text-dark" onclick="mostrarFormularioMedico()">Médico</button>
      </div>

      <!-- FORMULARIO PACIENTE -->
      <div id="formPaciente">
        <form id="loginPacienteForm">
          <!-- Usuario -->
          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text bg-dark text-light"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="usuarioPaciente" name="usuario" placeholder="Usuario" required />
            </div>
            <span id="usuarioPacienteError" class="text-danger ms-5" style="display:none;"></span>
          </div>
          <!-- Contraseña -->
          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text bg-dark text-light"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="clavePaciente" name="contrasena" placeholder="Contraseña" required />
              <button type="button" class="btn btn-outline-secondary" id="toggleClavePaciente"><i class="fa-solid fa-eye"></i></button>
            </div>
            <span id="clavePacienteError" class="text-danger ms-5" style="display:none;"></span>
          </div>
          <!-- Botón -->
          <div class="d-flex justify-content-center mb-3">
            <button type="button" class="btn btn-dark w-75 rounded-pill" onclick="enviarLoginPaciente()">Ingresar como paciente</button>
          </div>
        </form>
      </div>

      <!-- FORMULARIO MÉDICO -->
      <div id="formMedico" class="d-none">
        <form id="loginMedicoForm">
          <!-- Usuario -->
          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text bg-dark text-light"><i class="fas fa-user-md"></i></span>
              <input type="text" class="form-control" id="usuarioMedico" name="usuario" placeholder="Usuario médico" required />
            </div>
            <span id="usuarioMedicoError" class="text-danger ms-5" style="display:none;"></span>
          </div>
          <!-- Contraseña -->
          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text bg-dark text-light"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="claveMedico" name="contrasena" placeholder="Contraseña" required />
              <button type="button" class="btn btn-outline-secondary" id="toggleClaveMedico"><i class="fa-solid fa-eye"></i></button>
            </div>
            <span id="claveMedicoError" class="text-danger ms-5" style="display:none;"></span>
          </div>
          <!-- Botón -->
          <div class="d-flex justify-content-center mb-3">
            <button type="button" class="btn btn-dark w-75 rounded-pill" onclick="enviarLoginMedico()">Ingresar como médico</button>
          </div>
        </form>
      </div>

    </div>
  </div>

  <style>
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
      display: none;
    }
    input[type="password"]::-webkit-credentials-auto-fill-button {
      display: none !important;
    }
  </style>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="asset/js/login.js"></script>

  <script>
    function mostrarFormularioMedico() {
      document.getElementById("formPaciente").classList.add("d-none");
      document.getElementById("formMedico").classList.remove("d-none");
      const botones = document.querySelectorAll(".nav-link");
      botones[0].classList.remove("active", "bg-dark", "text-white");
      botones[0].classList.add("bg-light", "text-dark");
      botones[1].classList.add("active", "bg-dark", "text-white");
      botones[1].classList.remove("bg-light", "text-dark");
    }

    function mostrarFormularioPaciente() {
      document.getElementById("formMedico").classList.add("d-none");
      document.getElementById("formPaciente").classList.remove("d-none");
      const botones = document.querySelectorAll(".nav-link");
      botones[1].classList.remove("active", "bg-dark", "text-white");
      botones[1].classList.add("bg-light", "text-dark");
      botones[0].classList.add("active", "bg-dark", "text-white");
      botones[0].classList.remove("bg-light", "text-dark");
    }
  </script>

</body>
</html>
