<?php
include '../config/conexion.php';

// Consultar todos los clientes
$query = "SELECT * FROM clientes";
$result = mysqli_query($conexion, $query);

// Eliminar un cliente si se proporciona el parámetro 'delete' en la URL
if (isset($_GET['delete'])) {
    $id_cliente = $_GET['delete'];

    // Validar que el id_cliente es un número entero para evitar inyección SQL
    if (filter_var($id_cliente, FILTER_VALIDATE_INT)) {
        // Consulta preparada para eliminar el cliente
        $delete_query = "DELETE FROM clientes WHERE id_cliente = ?";
        $stmt = mysqli_prepare($conexion, $delete_query);
        mysqli_stmt_bind_param($stmt, "i", $id_cliente);

        if (mysqli_stmt_execute($stmt)) {
            echo "Cliente eliminado con éxito.";
            header('Location: clientes.php');
            exit;
        } else {
            echo 'No se pudo eliminar al cliente.';
        }
        mysqli_stmt_close($stmt); 
    } else {
        echo 'ID de cliente no válido.';
    }
}

// Procesar el registro de un cliente si se envía un formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprobar si las variables del formulario están definidas
    $cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
    $email = isset($_POST['correo_e']) ? $_POST['correo_e'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';

    // Validar que los campos no estén vacíos
    if ($cedula && $nombre && $apellido && $email && $telefono) {
        // Consulta preparada para insertar el cliente
        $insert_query = "INSERT INTO clientes (cedula, nombre, apellido, correo_e, telefono) 
        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $insert_query);
        mysqli_stmt_bind_param($stmt, "sssss", $cedula, $nombre, $apellido, $email, $telefono);

        if (mysqli_stmt_execute($stmt)) {
            echo 'Cliente registrado exitosamente.';
            header('Location: clientes.php');
            exit;
        } else {
            echo 'Error al registrar el cliente: ' . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
        echo 'Todos los campos son obligatorios.';
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Clientes</h1>
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirClientes"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cédula</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if (!$result) {
                        die('Error en la consulta: ' . mysqli_error($conexion));
                    }

                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['apellido']}</td>
                                    <td>{$row['cedula']}</td>
                                    <td>{$row['correo_e']}</td>
                                    <td>{$row['telefono']}</td>
                                    <td>
                                        <div class='d-flex'>
                                            <!-- Botón de Editar Cliente -->
                                            <a href='#' class='btn btn-sm btn-primary shadow-sm edit-btn flex-fill' 
                                            style='flex: 0 0 40%; margin-right: 5px;' 
                                            data-id='{$row['id_cliente']}'
                                            data-nombre='{$row['nombre']}'
                                            data-apellido='{$row['apellido']}'
                                            data-cedula='{$row['cedula']}'
                                            data-correo_e='{$row['correo_e']}'
                                            data-telefono='{$row['telefono']}'
                                            data-toggle='modal' 
                                            data-target='#EditarCliente'>
                                                <i class='fas fa-edit'></i> Editar
                                            </a>  

                                            <!-- Botón de Eliminar Cliente -->
                                            <a href='?delete={$row['id_cliente']}' class='btn btn-danger btn-sm flex-fill' 
                                            style='flex: 0 0 40%; margin-left: 5px;' 
                                            onclick='return confirm(\"¿Estás seguro que quieres eliminar?\")'>
                                                <i class='fas fa-trash'></i> Eliminar
                                                </a>
                                            </div>
                                        </td>

                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='06'>No hay clientes registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="clientes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Registrar Cliente</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input id="apellido" class="form-control" type="text" name="apellido" placeholder="apellido" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cedula">Cédula</label>
                                <input id="cedula" class="form-control" type="text" name="cedula" placeholder="Cédula" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="correo_e">Correo Electrónico</label>
                                <input id="correo_e" class="form-control" type="email" name="correo_e" placeholder="correo_e" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono" required>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="editarclientes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modal-title">Registrar Cliente</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="id_cliente" id="id_cliente">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input id="apellido" class="form-control" type="text" name="apellido" placeholder="Apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="cedula">Cédula</label>
                        <input id="cedula" class="form-control" type="text" name="cedula" placeholder="Cédula" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_e">Correo Electrónico</label>
                        <input id="correo_e" class="form-control" type="email" name="correo_e" placeholder="Correo Electrónico" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>
