<?php
include '../../config/conexion.php';

// Consulta para obtener las citas con el nombre del cliente
$sql = "SELECT citas.title, citas.start, citas.end, citas.color, clientes.nombre AS cliente_nombre
        FROM citas 
        JOIN clientes ON citas.id_cliente = clientes.id_cliente";  // Relación entre la tabla de citas y clientes

$query = $pdo->prepare($sql);
$query->execute();

// Obtener los resultados como un array asociativo
$resultado = $query->fetchAll(PDO::FETCH_ASSOC);

// Recorrer los resultados y asegurarse de que las fechas están en el formato correcto
foreach ($resultado as &$event) {
    // Si las fechas no tienen hora, agrega una hora predeterminada
    if (strpos($event['start'], 'T') === false) {
        $event['start'] = $event['start'] . "T09:00:00";
    }
    if (strpos($event['end'], 'T') === false) {
        $event['end'] = $event['end'] . "T10:00:00";
    }
}

// Imprimir los resultados para asegurarse de que los datos son correctos
echo json_encode($resultado); 
?>
