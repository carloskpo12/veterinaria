<?php
include '../config/conexion.php';

// Verificar si el formulario de actualización fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_mascota'])) {
    // Recoger los datos del formulario
    $id_mascota = $_POST['id_mascota'];
    $codigo = $_POST['codigo'];
    $nombre_mascota = $_POST['nombre_mascota'];
    $tipo = $_POST['tipo'];
    $genero = $_POST['genero'];
    $raza = $_POST['raza'];

    // Preparar la consulta SQL para actualizar los datos de la mascota
    $update_query = "UPDATE mascotas SET codigo = ?, nombre = ?, tipo = ?, genero = ?, raza = ? WHERE id_mascota = ?";
    $stmt = mysqli_prepare($conexion, $update_query);
    
    // Vincular los parámetros
    mysqli_stmt_bind_param($stmt, "sssssi", $codigo, $nombre_mascota, $tipo, $genero, $raza, $id_mascota);

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        echo "Mascota actualizada correctamente.";
        header('Location: mascota.php');
        exit;
    } else {
        echo "Error al actualizar la mascota.";
    }

    // Cerrar la declaración
    mysqli_stmt_close($stmt);
}

// Eliminar un cliente si se proporciona el parámetro 'delete' en la URL
if (isset($_GET['delete'])) {
    $id_mascota = $_GET['delete'];

    // Validar que el id_mascota es un número entero para evitar inyección SQL
    if (filter_var($id_mascota, FILTER_VALIDATE_INT)) {
        // Consulta preparada para eliminar la mascota
        $delete_query = "DELETE FROM mascotas WHERE id_mascota = ?";
        $stmt = mysqli_prepare($conexion, $delete_query);
        mysqli_stmt_bind_param($stmt, "i", $id_mascota);

        if (mysqli_stmt_execute($stmt)) {
            echo "Mascota eliminada con éxito.";
            header('Location: mascota.php');
            exit;
        } else {
            echo 'No se pudo eliminar la mascota.';
        }
        mysqli_stmt_close($stmt); 
    } else {
        echo 'ID de mascota no válido.';
    }
}

// Obtener lista de clientes para el formulario de agregar mascota
$clientes_query = "SELECT id_cliente, nombre FROM clientes";
$clientes_result = mysqli_query($conexion, $clientes_query);
$clientes = mysqli_fetch_all($clientes_result, MYSQLI_ASSOC);


$query_mascotas = "SELECT * FROM mascotas";
$result = mysqli_query($conexion, $query_mascotas);

if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}
?>

            <!-- Incluye el slider menú -->
<?php include 'includes/header.php'; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Mascota</h1>
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirmascota"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Género</th>
                    <th>Raza</th>
                    <th>Acciones</th>
                </tr>
                    <?php 
                    if (!$result) {
                        die('Error en la consulta: ' . mysqli_error($conexion));
                    }

                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['codigo']}</td>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['tipo']}</td>
                                    <td>{$row['genero']}</td>
                                    <td>{$row['raza']}</td>
                                        <td>
                                            <div class='d-flex'>
                                                <a href='#' class='btn btn-sm btn-primary shadow-sm edit-btn flex-fill' 
                                                style='flex: 0 0 40%; margin-right: 5px;' 
                                                data-id='{$row['id_mascota']}'
                                                data-codigo='{$row['codigo']}'
                                                data-nombre='{$row['nombre']}'
                                                data-tipo='{$row['tipo']}'
                                                data-genero='{$row['genero']}'
                                                data-raza='{$row['raza']}'
                                                data-toggle='modal' 
                                                data-target='#EditarMascota'>
                                                    <i class='fas fa-edit'></i> Editar
                                                </a>                                    
                                            
                                                <a href='?delete={$row['id_mascota']}' class='btn btn-danger btn-sm flex-fill' 
                                                style='flex: 0 0 40%; margin-left: 5px;' 
                                                onclick='return confirm('¿Estás seguro que quieres eliminar?')'>
                                                    <i class='fas fa-trash'></i> Eliminar
                                                </a>
                                            </div>
                                        </td>

                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='06'>No hay mascotas registradas.</td></tr>";
                    }
                    ?>

            </table>
        </div>
    </div>
</div>
<div id="mascotas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modal-title">Registrar Mascota</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Código" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_mascota">Nombre de la Mascota</label>
                                <input id="nombre_mascota" class="form-control" type="text" name="nombre_mascota" placeholder="Nombre de la Mascota" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select id="tipo" class="form-control" name="tipo" required>
                                    <option value="Perro">Perro</option>
                                    <option value="Gato">Gato</option>
                                    <option value="Ave">Ave</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="genero">Género</label>
                                <select id="genero" class="form-control" name="genero" required>
                                    <option value="Macho">Macho</option>
                                    <option value="Hembra">Hembra</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="raza">Raza</label>
                                <input id="raza" class="form-control" type="text" name="raza" placeholder="Raza" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_cliente">Cliente</label>
                                <select id="id_cliente" class="form-control" name="id_cliente" required>
                                    <?php foreach ($clientes as $cliente) : ?>
                                        <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar Mascota</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="EditarMascota" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modal-title">Editar Mascota</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="id_mascota" name="id_mascota">
                    <div class="form-group">
                        <label for="editCodigo">Código</label>
                        <input id="editCodigo" class="form-control" type="text" name="codigo" required>
                    </div>
                    <div class="form-group">
                        <label for="editNombreMascota">Nombre</label>
                        <input id="editNombreMascota" class="form-control" type="text" name="nombre_mascota" required>
                    </div>
                    <div class="form-group">
                        <label for="editTipo">Tipo</label>
                        <select id="editTipo" class="form-control" name="tipo" required>
                            <option value="Perro">Perro</option>
                            <option value="Gato">Gato</option>
                            <option value="Ave">Ave</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editGenero">Género</label>
                        <select id="editGenero" class="form-control" name="genero" required>
                            <option value="Macho">Macho</option>
                            <option value="Hembra">Hembra</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editRaza">Raza</label>
                        <input id="editRaza" class="form-control" type="text" name="raza" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>  
</body>
</html>
