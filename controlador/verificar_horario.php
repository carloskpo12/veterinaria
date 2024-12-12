<?php
include '../config/conexion.php';

$fecha = $_GET['fecha'] ?? null;

if (!$fecha) {
    echo json_encode(['error' => 'Fecha no proporcionada.']);
    exit;
}

try {
    $query = $pdo->prepare("SELECT hora_cita FROM citas WHERE fecha_cita = :fecha");
    $query->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $query->execute();

    $horas_ocupadas = $query->fetchAll(PDO::FETCH_COLUMN);

    // Horarios disponibles
    $horario = [
        '08:00 - 09:00',
        '09:00 - 10:00',
        '10:00 - 11:00',
        '11:00 - 12:00',
        '12:00 - 13:00',
        '13:00 - 14:00',
        '14:00 - 15:00',
        '15:00 - 16:00',
    ];

    // Deshabilitar horarios ocupados
    $horarios_disponibles = array_diff($horario, $horas_ocupadas);

    echo json_encode([
        'ocupados' => $horas_ocupadas,
        'disponibles' => $horarios_disponibles
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
