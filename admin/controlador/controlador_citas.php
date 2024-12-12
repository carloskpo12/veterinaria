<?php
include '../../config/conexion.php';

// Capturar la cédula enviada desde el formulario
$cedula = $_POST['id_cliente'];

// Buscar el `id_cliente` correspondiente a la cédula
$consulta_cliente = $pdo->prepare('SELECT id_cliente FROM clientes WHERE cedula = :cedula');
$consulta_cliente->bindParam(':cedula', $cedula);
$consulta_cliente->execute();
$resultado = $consulta_cliente->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $id_cliente = $resultado['id_cliente']; // Extraemos el `id_cliente`
} else {
    echo 'Cliente no encontrado en la base de datos';
    exit;
}

$nombre_mascota = $_POST['nombre_mascota'];
$tipo_de_servicio = $_POST['tipo_de_servicio'];
$fecha_cita = $_POST['fecha_cita'];  // Fecha en formato Y-m-d
$hora_cita = $_POST['hora_cita'];  // Hora en formato H:i:s
$descripcion = $_POST['descripcion'];
$title = $tipo_de_servicio;
$start = $fecha_cita . ' ' . $hora_cita; // Concatenar la fecha y hora
$end = $start;  // Si la cita tiene la misma hora de inicio y fin
$color = "#2324ff";  // Color predeterminado
$fechaHora = date('Y-m-d H:i:s');  // Fecha y hora de creación

// Preparar la consulta para insertar la cita
$sentencia = $pdo->prepare('INSERT INTO citas 
    (id_cliente, nombre_mascota, tipo_de_servicio, fecha_cita, hora_cita, descripcion, title, start, end, color, fyh_creacion)
    VALUES 
    (:id_cliente, :nombre_mascota, :tipo_de_servicio, :fecha_cita, :hora_cita, :descripcion, :title, :start, :end, :color, :fyh_creacion)');

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

if ($sentencia->execute()) {
    echo 'success';
} else {
    echo 'Error al registrar en la base de datos';
}
?>
