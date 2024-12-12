<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'login') {
        // Lógica de autenticación
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                        Ingrese usuario y contraseña
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            require_once "config/conexion.php";

            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));

            $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$user' AND clave = '$clave'");
            
            if (mysqli_num_rows($query) > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['id'] = $dato['id'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('Location: admin/clientes.php');
                exit();
            } else {
                $alert = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                            Usuario o contraseña incorrectos
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            }
        }
    } elseif (isset($_POST['form_type']) && $_POST['form_type'] === 'cita') {
        // Lógica de registro de citas
        if (isset($_POST['nombre_mascota'], $_POST['id_cliente'], $_POST['fecha_reserva'], $_POST['hora_cita'], $_POST['tipo_de_servicio'])) {
            require_once "config/conexion.php";

            $sentencia->bindParam(':id_cliente', $id_cliente);
            $sentencia->bindParam(':nombre_mascota', $nombre_mascota);
            $sentencia->bindParam(':tipo_de_servicio', $tipo_de_servicio);
            $sentencia->bindParam(':fecha_cita', $fecha_cita);
            $sentencia->bindParam(':hora_cita', $hora_cita);
            $sentencia->bindParam(':descripcion', $descripcion);
            $sentencia->bindParam(':title', $title);
            $sentencia->bindParam(':start', $start);
            $sentencia->bindParam(':end', $end);
            $sentencia->bindParam(':color', $color);
            $sentencia->bindParam(':fyh_creacion', $fechaHora);

            $fecha_hora = $fecha_reserva . ' ' . $hora_cita;

            // Preparar la consulta para insertar la cita
                $sentencia = $pdo->prepare('INSERT INTO citas 
                (id_cliente, nombre_mascota, tipo_de_servicio, fecha_cita, hora_cita, descripcion, title, start, end, color, fyh_creacion)
                VALUES 
                (:id_cliente, :nombre_mascota, :tipo_de_servicio, :fecha_cita, :hora_cita, :descripcion, :title, :start, :end, :color, :fyh_creacion)');


            if ($conexion->query($sql) === TRUE) {
                echo "Cita registrada exitosamente.";
            } else {
                echo "Error al registrar la cita: " . $conexion->error;
            }

            $conexion->close();
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
                <form class="user" method="POST" action="" autocomplete="off">
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
            <section class="principal">
        <section class="contenedor">
        <section class="contenedorformulario">
        <section class="formulario" id="formulario-cita">
    <h3>Solicita Cita Médica</h3>
    <form action="index.php" method="POST">
        <input type="hidden" name="form_type" value="cita">
        <label for="nombre_mascota" class="form-label">Nombre de la mascota</label>
        <input type="text" name="nombre_mascota" class="form-control" id="nombre_mascota" placeholder="Ejemplo: Max" required>
        
        <label for="cedula" class="form-label">Cédula</label>
        <input type="text" name="id_cliente" class="form-control" id="cedula" placeholder="Ejemplo: 123456789" required>
        
        <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
        <select class="form-select" name="tipo_de_servicio" id="tipo_servicio" required>
            <option value="" selected disabled>Selecciona un servicio</option>
            <option value="consulta">Consulta médica</option>
            <option value="vacunacion">Vacunación</option>
            <option value="baño">Baño</option>
        </select>
        
        <label for="fecha_reserva" class="form-label">Fecha de reserva</label>
        <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" required>
        
        <label for="hora_reserva" class="form-label">Hora de cita</label>
        <select class="form-select" name="hora_cita" id="hora_reserva" required>
            <option value="" selected disabled>Selecciona la hora de la reserva</option>
            <option value="08:00 - 09:00">08:00 - 09:00</option>
            <option value="09:00 - 10:00">09:00 - 10:00</option>
            <option value="10:00 - 11:00">10:00 - 11:00</option>
            <option value="11:00 - 12:00">11:00 - 12:00</option>
            <option value="12:00 - 13:00">12:00 - 13:00</option>
            <option value="13:00 - 14:00">13:00 - 14:00</option>
            <option value="14:00 - 15:00">14:00 - 15:00</option>
            <option value="15:00 - 16:00">15:00 - 16:00</option>
            <option value="16:00 - 17:00">16:00 - 17:00</option>
            <option value="17:00 - 18:00">17:00 - 18:00</option>
        </select>
        
        <label for="notas" class="form-label">Notas adicionales</label>
        <textarea class="form-control" name="descripcion" id="notas" rows="3" placeholder="Información adicional sobre la cita"></textarea>
        
        <button type="submit" class="btn btn-primary">Registrar cita</button>
    </form>
</section>

            </section>
        </section>
    </section>

    <footer>
        <section class="pie">
            <section class="textocentado">    
                <p>Contacto</p>
                <p>Línea Gratuita: 1-800-000-0001</p>
                <p>Correo: preguntas@caninosyfelinos.com</p>
                <p>Todos los derechos reservados 2024 LilOSBer;</p>
            </section>
            <section class="logoend">
                <img src="assets/imagenes/Logo.png" alt="logofooter">
            </section>
        </section>
    </footer>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('fecha_reserva').addEventListener('change', function () {
    var fecha = this.value;
    var url = "admin/controlador/verificar_horario.php";

    // Realizar la solicitud AJAX
    $.get(url, { fecha: fecha })
        .done(function (datos) {
            try {
                var respuesta = JSON.parse(datos);

                if (respuesta.error) {
                    alert(respuesta.error);
                    return;
                }

                var selectHoras = document.getElementById('hora_reserva');
                selectHoras.innerHTML = ''; // Limpiar el contenido previo

                var horarios = [
                    '08:00 - 09:00',
                    '09:00 - 10:00',
                    '10:00 - 11:00',
                    '11:00 - 12:00',
                    '12:00 - 13:00',
                    '13:00 - 14:00',
                    '14:00 - 15:00',
                    '15:00 - 16:00',
                    '16:00 - 17:00',
                    '17:00 - 18:00'
                ];

                horarios.forEach(function (horario) {
                    var option = document.createElement('option');
                    option.value = horario;
                    option.textContent = horario;

                    if (respuesta.ocupados.includes(horario)) {
                        option.disabled = true; // Deshabilitar horas ocupadas
                    }

                    selectHoras.appendChild(option);
                });
            } catch (e) {
                alert('Error procesando la respuesta del servidor.');
            }
        })
        .fail(function () {
            alert('Hubo un error al verificar los horarios.');
        });
});

</script>
</body>
</html>