<?php
include 'config/conexion.php';
// PHP: Lógica del inicio de sesión
if (isset($_POST['form_type']) && $_POST['form_type'] === 'login') {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
        $alert = '<div class="alert alert-danger">Ingrese usuario y contraseña</div>';
    } else {
        require_once "config/conexion.php";

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $_POST['usuario']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($_POST['clave'], $user['clave'])) {
            session_start();
            $_SESSION['active'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['user'] = $user['usuario'];
            header('Location: admin/clientes.php');
            exit();
        } else {
            $alert = '<div class="alert alert-danger">Usuario o contraseña incorrectos</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Cita</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .custom-btn {
            font-size: 18px;
            padding: 15px 30px;
            min-width: 220px;
            margin: 10px;
            transition: background-color 0.3s ease;
        }
        .custom-btn:hover {
            background-color: #004085 !important;
            color: white !important;
        }
        .fc-toolbar-title {
            font-weight: bold;
            font-size: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body>
<header>
    <section class="contenedorheader">
        <section class="fondo">  
            <section class="menu">    
                <nav>
                    <ul>
                        <li><a href="./index.php">Inicio</a></li>
                        <li><a href="./servicios.php">Servicios</a></li>
                        <li><a href="./productos.php">Productos</a></li>
                        <li><a href="./guarderia.php">Guardería</a></li>
                        <li><a href="./promocion.php">Promociones</a></li>
                    </ul>
                </nav>
            </section>
            <section class="logo">
                <img src="assets/imagenes/Logo.png" alt="logo">
            </section>
            <section class="login-form" id="formulario-login">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form id="form-login" class="user" method="POST" action="" autocomplete="off">
                    <input type="hidden" name="form_type" value="login">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="usuario" name="usuario" placeholder="Usuario...">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user" id="clave" name="clave" placeholder="Password">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
                    <hr>
                </form>
            </section>
        </section>
    </section>
</header>

<section class="principal">
    <section class="contenedor">
        <article class="contenedor1">
            <section class="titulo">
                <img src="assets/imagenes/huella.png" alt="huella" class="huella">
                <h2>Ventajas de cuidar a tu mascota</h2>
            </section>
            <img src="assets/imagenes/cuidadoMascotas.jpg" alt="Perro y gato" class="imagenes">
            <p>Al cuidar de tu mascota puedes mejorar tu salud física y mental.</p>
            <p>¿Sabías que la hormona Oxitocina, que se secreta cuando el cuerpo experimenta placer, también se secreta cuando una mascota y su dueño experimentan interacciones positivas entre sí?</p>
            <a href="#">Ver más...</a>
        </article>

        <article class="contenedor1">
            <section class="titulo">
                <img src="assets/imagenes/huella.png" alt="huella" class="huella">
                <h2>La importancia de una buena alimentación</h2>
            </section>
            <img src="assets/imagenes/gatoPerroComiendo.jpg" alt="Perro y gato" class="imagenes">
            <p>La alimentación de un perro es la base para poder vivir y dependiendo de ella, la salud del animal variará para bien o para mal.</p>
            <p>Los perros en un principio eran carnívoros. Pertenecen a la especie Canis familiaris y están incluidos en el grupo de los carnívoros, donde también se encuentran los lobos, los osos, los gatos y otros muchos animales.</p>
            <a href="#">Ver más...</a>
        </article>

        <article class="contenedor1">
            <section class="titulo">
                <img src="assets/imagenes/huella.png" alt="huella" class="huella">
                <h2>Peluquería canina</h2>
            </section>
            <img src="assets/imagenes/peluqueriaCanina.jpg" alt="Perro y gato" class="imagenes">
            <p>La salud del animal también debe pasar por un cuidado del pelaje, verificando la ausencia de dermatopatías como seborreas, prurito o piodermas.</p>
            <p>Somos fanáticos de la salud integral de las mascotas y disponemos de peluquería canina con el champú adecuado para cada tipo de piel, tratando con champús medicamentosos en los casos que lo requieran como parte de un plan integral de salud animal.</p>
            <a href="#">Ver más...</a>
        </article>

        <section class="contenedorformulario">
            <aside>            
            <section class="formulario" id="formulario-cita">
                <h3>Solicita Cita Médica</h3>
                <form>
                    <!-- Aplicamos clases de Bootstrap para hacer el botón más grande -->
                    <button type="button" class="btn btn-primary btn-lg w-100 h-100" data-bs-toggle="modal" data-bs-target="#modal_cita">
                        Reservar cita
                    </button> <br>
                    <h2><p>Oprime aquí para registrar una cita</p></h2>
                </form>
            </section>

            </aside>
        </section>
    </section>
</section>

<!-- Modal -->
<div class="modal fade" id="modal_cita" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reserva cita para el día <span id="dia_de_la_semana"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Turno de la mañana -->
          <div class="col-md-6">
            <center><b>Turno de la mañana</b></center>
            <div class="d-grid gap-3">
            <button class="btn btn-success custom-btn" data-hora="08:00 - 09:00" id="btn_h1" type="button">08:00 - 09:00</button>
            <button class="btn btn-success custom-btn" data-hora="09:00 - 10:00" id="btn_h2" type="button">09:00 - 10:00</button>
            <button class="btn btn-success custom-btn" data-hora="10:00 - 11:00" id="btn_h3" type="button">10:00 - 11:00</button>
            <button class="btn btn-success custom-btn" data-hora="11:00 - 12:00" id="btn_h4" type="button">11:00 - 12:00</button>

            </div>
          </div>

          <!-- Turno de la tarde -->
          <div class="col-md-6">
            <center><b>Turno de la tarde</b></center>
            <div class="d-grid gap-3">
            <button class="btn btn-success custom-btn" data-hora="12:00 - 13:00" id="btn_h1" type="button">12:00 - 13:00</button>
            <button class="btn btn-success custom-btn" data-hora="13:00 - 14:00" id="btn_h2" type="button">13:00 - 14:00</button>
            <button class="btn btn-success custom-btn" data-hora="14:00 - 15:00" id="btn_h3" type="button">14:00 - 15:00</button>
            <button class="btn btn-success custom-btn" data-hora="15:00 - 16:00" id="btn_h4" type="button">15:00 - 16:00</button>

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de formulario -->
<div class="modal fade" id="modal_formulario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Reserva cita para el día <span id="dia_de_la_semana"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="controlador/controlador_citas.php" method="post">
        <div class="row mb-3">
            <div class="col-md-6">
              <label for="nombre_mascota" class="form-label">Nombre de la mascota</label>
              <input type="text" name="nombre_mascota" class="form-control" id="nombre_mascota" placeholder="Ejemplo: Max">
            </div>
              <div class="col-md-6">
                <label for="cedula" class="form-label">cedula</label>
                <input type="text" name="id_cliente" class="form-control" id="cedula" placeholder="Ejemplo: 123456789">
              </div>
            <div class="col-md-6">  
              <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
              <select class="form-select" name="tipo_de_servicio" id="tipo_servicio">
                <option value="" selected disabled>Selecciona un servicio</option>
                <option value="consulta">Consulta médica</option>
                <option value="vacunacion">Vacunación</option>
                <option value="baño">Baño</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="fecha_reserva" class="form-label">Fecha de reserva</label>
              <input type="date" name="fecha_cita" class="form-control" id="fecha_reserva2">
            </div>
            <div class="col-md-6">
              <label for="hora_reserva" class="form-label">Hora de reserva</label>
              <input type="text" class="form-control" id="hora_reserva" disabled>
              <input type="text" name="hora_cita" class="form-control" id="hora_reserva2" hidden>

            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="notas" class="form-label">Notas adicionales</label>
              <textarea class="form-control" name="descripcion" id="notas" rows="3" placeholder="Información adicional sobre la cita"></textarea>
            </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Registrar cita</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Incluir jQuery y Bootstrap antes de tu script de modales -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var a; 
    $(document).ready(function() {
        // Función para manejar el evento de la fecha seleccionada
        function manejarEvento(info) {
            var selectedDate = info.dateStr;
            var date = new Date(selectedDate);
            var dayOfWeek = date.getDay();
            var days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            a = selectedDate;

            if (dayOfWeek === 5 || dayOfWeek === 6) {
                alert("No hay atención en este día");
            } else {
                $('#modal_cita').modal('show');
                $('#dia_de_la_semana').text(days[dayOfWeek]);

                var fecha = info.dateStr;
                var url = "controlador/verificar_horario.php";

                $.get(url, { fecha: fecha })
                    .done(function(datos) {
                        try {
                            var respuesta = JSON.parse(datos);

                            if (respuesta.error) {
                                alert(respuesta.error);
                                return;
                            }

                            // Limpiar estilos previos
                            $('button[id^="btn_h"]').prop('disabled', false).css('background-color', '');

                            // Deshabilitar horarios ocupados
                            respuesta.ocupados.forEach(function(horario, index) {
                                var btnId = "#btn_h" + (index + 1); 
                                $(btnId).prop('disabled', true).css('background-color', 'red');
                            });
                        } catch (e) {
                            alert('Error procesando la respuesta del servidor.');
                        }
                    })
                    .fail(function() {
                        alert('Hubo un error al verificar los horarios.');
                    });
            }
        }

    // Evento para cuando se hace clic en el botón de hora personalizada
    $(document).on('click', '.custom-btn', function () {
        var horaSeleccionada = $(this).data('hora'); 
        $('#modal_cita').modal('hide');
        $('#modal_formulario').modal('show');
        
        // Asignar la fecha a los campos de fecha
        $('#fecha_reserva').val(a);
        $('#fecha_reserva2').val(a);

        // Asignar la hora a los campos de hora
        $('#hora_reserva').val(horaSeleccionada);
        $('#hora_reserva2').val(horaSeleccionada);
    });
});
</script>
</body>
<html></html>