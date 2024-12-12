<?php
include '../config/conexion.php';
include 'includes/header.php';
?>
    <title>Agenda de Citas</title>
    <head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <!-- Estilo personalizado -->
<head>
<style>
  .custom-btn {
    font-size: 18px; 
    padding: 15px 30px;
    min-width: 220px; 
    margin: 10px;
  }
  
  .fc-toolbar-title {
    font-weight: bold;
    font-size: 1.5rem;
    color: #333;
}

.custom-btn {
    transition: background-color 0.3s ease;
}

.custom-btn:hover {
    background-color: #004085 !important;
    color: white !important;
}

</style>
  </head>
  <body>
    <div id='calendar'></div>
    <?php include("includes/footer.php"); ?>

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
              <input type="date" class="form-control" id="fecha_reserva" disabled>
              <input type="date" name="fecha_cita" class="form-control" id="fecha_reserva2" hidden>
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
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridDay,listWeek'
        },
        editable: true,
        selectable: true,
        allDaySlot: false,
        businessHours: {
            daysOfWeek: [1, 2, 3, 4, 5], // Lunes a viernes
            startTime: '08:00',
            endTime: '16:00', // Horario laboral
        },
        validRange: {
            start: new Date().toISOString().split('T')[0],
        },
        events: 'controlador/cargar_citas.php',
        eventClick: function(info) {
            // Mostrar el nombre del cliente
            var clienteNombre = info.event.extendedProps.cliente_nombre; // Obtener el nombre del cliente
            alert('Cita: ' + info.event.title + '\nCliente: ' + clienteNombre); 
        },
        dateClick: function(info) {
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
    });

    // Inicializar el calendario
    calendar.render();

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
