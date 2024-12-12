<?php
include '../config/conexion.php';

// Parámetros de paginación
$limit = 20; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit; 

// Búsqueda de datos
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Consulta de vacunas
$vacunas_query = "SELECT id_vacuna, nombre FROM vacunas";
$vacunas_result = mysqli_query($conexion, $vacunas_query);
$vacunas = mysqli_fetch_all($vacunas_result, MYSQLI_ASSOC);

// Consulta de mascotas
$mascotas_query = "SELECT id_mascota, nombre FROM mascotas";
$mascotas_result = mysqli_query($conexion, $mascotas_query);
$mascotas = mysqli_fetch_all($mascotas_result, MYSQLI_ASSOC);

// Consulta de clientes
$clientes_query = "SELECT id_cliente, nombre, cedula FROM clientes";
$clientes_result = mysqli_query($conexion, $clientes_query);
$clientes = mysqli_fetch_all($clientes_result, MYSQLI_ASSOC);

// Consulta para obtener las aplicaciones de vacunas con paginación y búsqueda
$consulta_vacunas = "
    SELECT 
        aplicacion_vacunas.id_aplicacion_vacuna, 
        mascotas.nombre AS mascota, 
        vacunas.nombre AS vacuna, 
        aplicacion_vacunas.fecha_tratamiento,
        clientes.nombre AS cliente, 
        clientes.cedula
    FROM aplicacion_vacunas
    JOIN mascotas ON aplicacion_vacunas.id_mascota = mascotas.id_mascota
    JOIN vacunas ON aplicacion_vacunas.id_vacuna = vacunas.id_vacuna
    JOIN clientes ON mascotas.cliente = clientes.id_cliente
    WHERE 
        mascotas.nombre LIKE '%$search%' OR 
        vacunas.nombre LIKE '%$search%' OR 
        clientes.nombre LIKE '%$search%' OR
        clientes.cedula LIKE '%$search%' OR
        aplicacion_vacunas.fecha_tratamiento LIKE '%$search%' 
    LIMIT $limit OFFSET $offset
";
$result_vacunas = mysqli_query($conexion, $consulta_vacunas);

// Contar el total de registros para la paginación
$total_query = "
    SELECT COUNT(*) as total 
    FROM aplicacion_vacunas
    JOIN mascotas ON aplicacion_vacunas.id_mascota = mascotas.id_mascota
    JOIN vacunas ON aplicacion_vacunas.id_vacuna = vacunas.id_vacuna
    JOIN clientes ON mascotas.cliente = clientes.id_cliente
    WHERE 
        mascotas.nombre LIKE '%$search%' OR 
        vacunas.nombre LIKE '%$search%' OR 
        clientes.nombre LIKE '%$search%' OR
        clientes.cedula LIKE '%$search%' OR
        aplicacion_vacunas.fecha_tratamiento LIKE '%$search%'
";
$total_result = mysqli_query($conexion, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit); 

// Verificar si el formulario de aplicación de vacuna fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_mascota'])) {
    // Recoger los datos del formulario
    $id_mascota = $_POST['id_mascota'];
    $id_vacuna = $_POST['id_vacuna'];
    $fecha_tratamiento = $_POST['fecha_tratamiento'];
    $proximo_tratamiento = $_POST['proximo_tratamiento'];
    $observacion = $_POST['observacion'];

    // Preparar la consulta SQL para registrar la aplicación de la vacuna
    $insert_query = "INSERT INTO aplicacion_vacunas (id_mascota, id_vacuna, fecha_tratamiento, proximo_tratamiento, observacion) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $insert_query);
    
    // Vincular los parámetros
    mysqli_stmt_bind_param($stmt, "iisss", $id_mascota, $id_vacuna, $fecha_tratamiento, $proximo_tratamiento, $observacion);

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        echo "Vacuna aplicada correctamente.";
        header('Location: vacuna.php'); 
        exit;
    } else {
        echo "Error al aplicar la vacuna.";
    }

    // Cerrar la declaración
    mysqli_stmt_close($stmt);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
$conn = new mysqli('localhost', 'usuario', 'contraseña', 'nombre_base_de_datos');
    
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$objetivo = $_POST['objetivo'];

// Preparar la consulta para insertar los datos en la tabla 'vacunas'
$sql = "INSERT INTO vacunas (codigo, nombre, objetivo) VALUES (?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    // Enlazar los parámetros y ejecutar la consulta
    $stmt->bind_param("sss", $codigo, $nombre, $objetivo);
    if ($stmt->execute()) {
        echo "Vacuna registrada con éxito.";
    } else {
        echo "Error al registrar la vacuna: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
}
?>

<!-- Incluye el slider menú -->
<?php include 'includes/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mr-1">
    <h1 class="h3 mb-0 text-gray-800">Aplicación de Vacunas</h1>
    <!-- Enlace para abrir el modal -->
    <div class="d-sm-flex align-items-center justify-content-between mr-1">
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abriraplicacion">
        <i class="fas fa-plus fa-sm text-white-50"></i> aplicar vacuna
    </a>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ml-2" id="abrirvacuna">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nueva vacuna
    </a>
    </div>
</div>


<!-- Formulario de búsqueda -->
<form method="POST" action="vacuna.php" class="mb-3">
    <input type="text" name="search" class="form-control" placeholder="Buscar por mascota, cliente, cédula, vacuna o fecha" value="<?php echo $search; ?>">
</form>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Cliente</th>
                        <th>Cédula</th>
                        <th>Nombre de la Mascota</th>
                        <th>Vacuna</th>
                        <th>Fecha de Aplicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($result_vacunas) > 0) {
                        while($row = mysqli_fetch_assoc($result_vacunas)) {
                            echo "<tr>
                                    <td>{$row['cliente']}</td>
                                    <td>{$row['cedula']}</td>
                                    <td>{$row['mascota']}</td>
                                    <td>{$row['vacuna']}</td>
                                    <td>{$row['fecha_tratamiento']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay aplicaciones de vacunas registradas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Paginación -->
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo ($page - 1); ?>">Anterior</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php echo ($page == $total_pages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo ($page + 1); ?>">Siguiente</a>
        </li>
    </ul>
</nav>


<!-- Modal para registrar nueva aplicación de vacuna -->
<div id="aplicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modal-title">Registrar aplicación</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_mascota">Mascota</label>
                                <select id="id_mascota" class="form-control" name="id_mascota" required>
                                    <?php foreach ($mascotas as $mascota) : ?>
                                        <option value="<?= $mascota['id_mascota'] ?>"><?= $mascota['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_vacuna">Vacuna</label>
                                <select id="id_vacuna" class="form-control" name="id_vacuna" required>
                                    <?php foreach ($vacunas as $vacuna) : ?>
                                        <option value="<?= $vacuna['id_vacuna'] ?>"><?= $vacuna['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_tratamiento">Fecha de Tratamiento</label>
                                <input id="fecha_tratamiento" class="form-control" type="datetime-local" name="fecha_tratamiento" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proximo_tratamiento">Próximo Tratamiento</label>
                                <input id="proximo_tratamiento" class="form-control" type="date" name="proximo_tratamiento">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observacion">Observación</label>
                                <textarea id="observacion" class="form-control" name="observacion"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar Aplicación</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="vacuna" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modal-title">Registrar Nueva Vacuna</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="registrar_vacuna.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo">Código de Vacuna</label>
                                <input id="codigo" class="form-control" type="text" name="codigo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre de la Vacuna</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="objetivo">Objetivo de la Vacuna</label>
                                <input id="objetivo" class="form-control" type="text" name="objetivo" required>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar Vacuna</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
<script>
    // JavaScript para abrir el modal
    document.getElementById("abrirvacuna").addEventListener("click", function() {
        $('#vacuna').modal('show');
    });
    document.getElementById("abriraplicacion").addEventListener("click", function() {
        $('#aplicacion').modal('show');
    });
</script>
</body>
</html>
