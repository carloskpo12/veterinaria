<?php
require_once "config/conexion.php";
if (isset($_POST)) {
    if ($_POST['action'] == 'buscar') {
        $array['datos'] = array();
        $total = 0;
        for ($i=0; $i < count($_POST['data']); $i++) { 
            $id = $_POST['data'][$i]['id'];
            $query = mysqli_query($conexion, "SELECT * FROM productos WHERE id_producto  = $id");
            $result = mysqli_fetch_assoc($query);
            $data['id'] = $result['id_producto'];
            $data['precio'] = $result['descuento'];
            $data['nombre'] = $result['nombre'];
            $total = $total + $result['descuento'];
            array_push($array['datos'], $data);
        }
        $array['total'] = $total;
        echo json_encode($array);
        die();
    }
}
?>

