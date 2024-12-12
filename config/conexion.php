<?php
    // Conexión con MySQLi
    $host = "localhost";
    $user = "root";
    $clave = "";
    $bd = "veterinaria";
    $conexion = mysqli_connect($host, $user, $clave, $bd);
    
    if (mysqli_connect_errno()) {
        echo "No se pudo conectar a la base de datos";
        exit();
    }
    
    mysqli_select_db($conexion, $bd) or die("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    // Conexión con PDO
    try {
        // Crear una instancia de PDO
        $pdo = new PDO("mysql:host=$host;dbname=$bd", $user, $clave);
        
        // Establecer el modo de error de PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    } catch (PDOException $e) {
        // En caso de error, muestra el mensaje de excepción
        echo "Conexión fallida: " . $e->getMessage();
    }
?>
