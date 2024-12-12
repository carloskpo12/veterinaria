<?php
session_start();

if (!empty($_SESSION['active'])) {
    header('Location: admin/clientes.php');
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $alert = '';

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
            
            $resultado = mysqli_num_rows($query);

            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['id'] = $dato['id'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('Location: admin/clientes.php');
                exit();
            } else {
                $alert = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                            Contraseña incorrecta
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                session_destroy(); 
            }
        }
    }
}

// Verificar si el formulario de citas fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mascota'], $_POST['cedula'], $_POST['fecha'], $_POST['hora'], $_POST['edad'], $_POST['raza'])) {

    // Obtener los datos del formulario
    $codigo_mascota = $_POST['mascota'];
    $cedula_cliente = $_POST['cedula'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $edad = $_POST['edad'];
    $raza = $_POST['raza'];

    // Combinar fecha y hora en un solo campo
    $fecha_hora = $fecha . " " . $hora;

    // Conectar a la base de datos
    require_once "config/conexion.php";

    // Verificar si la mascota existe en la base de datos
    $sql_mascota = "SELECT id_mascota FROM mascotas WHERE codigo = '$codigo_mascota'";
    $result_mascota = $conexion->query($sql_mascota);

    if ($result_mascota->num_rows == 0) {
        die("La mascota con el código $codigo_mascota no existe.");
    }

    $mascota_id = $result_mascota->fetch_assoc()['id_mascota'];

    // Verificar si el cliente existe en la base de datos
    $sql_cliente = "SELECT id_cliente FROM clientes WHERE cedula = '$cedula_cliente'";
    $result_cliente = $conexion->query($sql_cliente);

    if ($result_cliente->num_rows == 0) {
        die("El cliente con la cédula $cedula_cliente no está registrado.");
    }

    $cliente_id = $result_cliente->fetch_assoc()['id_cliente'];

    // Insertar la cita en la tabla `citas`
    $sql = "INSERT INTO citas (fecha_hora, descripcion, estado_cita, id_mascota, id_cliente)
            VALUES ('$fecha_hora', 'Cita para revisión', 'Pendiente', '$mascota_id', '$cliente_id')";

    if ($conexion->query($sql) === TRUE) {
        echo "Cita registrada exitosamente.";
    } else {
        echo "Error al registrar la cita: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} 
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Cita</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
// Validación del formulario de citas
function validarFormularioCita() {
    const mascota = document.getElementById("mascota").value;
    const edad = document.getElementById("edad").value;
    const raza = document.getElementById("raza").value;
    const fecha = document.getElementById("fecha").value;
    const hora = document.getElementById("hora").value;
    const cedula = document.getElementById("cedula").value;

    if (!mascota || !edad || !raza || !fecha || !hora || !cedula) {
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Por favor complete todos los campos antes de enviar el formulario.',
        });
        return false;
    }

    // Validación de fecha y hora
    const fechaActual = new Date(); // Fecha actual
    const fechaIngresada = new Date(`${fecha}T${hora}`); // Combina la fecha y la hora seleccionada
    const fechaSoloIngresada = new Date(fecha); // Solo la fecha, sin la hora

    // Si la fecha ingresada es menor a la fecha actual
    if (fechaSoloIngresada < fechaActual.setHours(0, 0, 0, 0)) {
        Swal.fire({
            icon: 'error',
            title: 'Fecha inválida',
            text: 'No puedes seleccionar una fecha pasada.',
        });
        return false;
    }

    // Si la fecha ingresada es hoy pero la hora seleccionada es en el pasado
    if (fechaSoloIngresada.getTime() === fechaActual.setHours(0, 0, 0, 0) && fechaIngresada < fechaActual) {
        Swal.fire({
            icon: 'error',
            title: 'Hora inválida',
            text: 'No puedes seleccionar una hora en el pasado.',
        });
        return false;
    }

    return true;
}



// Ocultar alertas automáticamente después de 5 segundos
function ocultarAlerta() {
    const alertas = document.querySelectorAll('.alert');
    alertas.forEach(alerta => {
        setTimeout(() => {
            alerta.style.display = 'none';
        }, 5000);
    });
}

window.onload = function () {
    ocultarAlerta();  // Ocultar alertas automáticamente al cargar la página
};

</script>


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
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="usuario" name="usuario" placeholder="Usuario...">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user" id="clave" name="clave" placeholder="Password">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                        Login
                    </button>
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
                <aside>
                    <section class="formulario" id="formulario-cita">
                        <h3>Solicita Cita Médica</h3>
                            <form action="index.php" method="POST" onsubmit="return validarFormularioCita()">
                        <label for="mascota">Código de Mascota:</label>
                        <input type="text" id="mascota" name="mascota" required>

                        <label for="edad">Edad de la Mascota:</label>
                        <input type="text" id="edad" name="edad" required>

                        <label for="raza">Raza de la Mascota:</label>
                        <input type="text" id="raza" name="raza" required>

                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" required>

                        <label for="hora">Hora:</label>
                        <input type="time" id="hora" name="hora" required>

                        <label for="cedula">Cédula del Amo (Cliente):</label>
                        <input type="text" id="cedula" name="cedula" required>

                        <button type="submit">Registrar Cita</button>
                    </form>
                        </section>


                    </section>
                </aside>
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

</body>
</html>