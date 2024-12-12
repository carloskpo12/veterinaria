<?php
if (isset($_GET)) {
    if (!empty($_GET['accion']) && !empty($_GET['id'])) {
        require_once "../config/conexion.php";
        $id = $_GET['id'];

        // Eliminar productos
        if ($_GET['accion'] == 'pro') {
            $query = mysqli_query($conexion, "DELETE FROM productos WHERE id = $id");
            if ($query) {
                header('Location: productos.php');
            }
        }

        // Eliminar categorías
        if ($_GET['accion'] == 'cat') {
            $query = mysqli_query($conexion, "DELETE FROM categorias WHERE id = $id");
            if ($query) {
                header('Location: categorias.php');
            }
        }

        // Eliminar clientes
        if ($_GET['accion'] == 'cli') {
            $query = mysqli_query($conexion, "DELETE FROM clientes WHERE id = $id");
            if ($query) {
                header('Location: clientes.php');
            }
        }
    }
}
?>
