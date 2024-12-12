<?php require_once "config/conexion.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Productos</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/productos.css">
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
            </section>
        </section>
        
        <main>
            <section class="principal">
                <section class="secundario">
                    <img src="assets/imagenes/gatoPerroComiendo.jpg" alt="imagenfloa" class="imagenfloat">
                    <img src="assets/imagenes/gatico.png" alt="gatico" class="huella">
                    <h1>La importancia de una buena alimentación</h1>
                    <br>
                    <p>La alimentación de un perro es la base para poder vivir y dependiendo de ella, la salud del animal variará para bien o para mal.</p>
                    <br>
                    <p>Los perros en un principio eran carnivoros. Pertenecen a la especie canis familiaris y están incluidos en el grupo de los carnivoros, donde también se encuentran los lobos, los osos, los gatos, y otros muchos animales.</p>
                    <br>
                    <p>Pero desde que se hizo amigo del hombre, ha cambiado sus hábitos alimenticios. Ya no son unos carnivoros estrictos y su capacidad metabólica ha cambiado, pero su alimentación sigue siendo mayoritariamente de carne. Lo cierto es que el perro actual es prácticamente omnivoro.</p>
                    <br>
                    <h4>Lo básico</h4>
                    <p>Dejando a un lado los nutrientes básicos necesarios para todo animal (agua, albúmina, hidratos de carbono, grasas y sales) son también imprescindibles las vitaminas. Si el aporte de nutrientes y energía es inadecuado, la salud de nuestra mascota no será buena. Y esta incorrecta alimentación le provocará, tarde o temprano, a nuestro perro la aparición de patologias.</p>
                    <br>
                    <p>Hay que tener en cuenta que los mecanismos fisiológicos del perro y del hombre son parecidos, pero distintos. Hay algunos alimentos que el perro no es capaz o no puede metabolizar de la misma manera que lo hace el hombre. Su metabolismo no es tan eficaz como el del ser humano. Sabiendo esto, se puede evitar cometer errores en la alimentación.</p>
                    <br>
                    <h4>Errores más frecuentes</h4>
                    <br>
                    <p>Muchos dueños no se fian de las dietas comerciales debido a que creen que sus componentes no son naturales. En vez de eso, lo que hacen es prepararles ellos mismos las comidas, pues creen que si a ellos les sienta bien, a sus mascotas también. Pero esto es erróneo. Como acabamos de decir en el apartado anterior, el metabolismo de los perros es diferente del de los humanos.</p>
                    <br>
                    <p>El problema no es alimentarles con alimentos frescos, que son buenos, sino la cantidad y proporción de nutrientes que les debemos suministrar y que estos necesitan. Los productos comerciales están hechos por nutricionistas y contienen la información sobre las cantidades adecuadas para cada perro. Los productos llamados "Premium" tienen este nombre por su mayor digestibilidad para los animales y, evidentemente, por su mayor calidad.</p>
                    <img src="assets/imagenes/malaAlimentacion.jpg" alt="imagenfloa" class="imagenfloat2">
                    <br>
                    <h4>Diferentes soluciones y consejos</h4>
                    <br>
                    <p>Teniendo en cuenta todo esto, ya podemos actuar de forma correcta. Una vez elegido el tipo de dieta que va a seguir, debemos asegurarnos de que sea la mejor posible. Debe ser agradable al gusto del perro. Esto será más fácil con los productos comerciales, como ya he dicho antes, pues viene detallado todos los componentes y las raciones a proporciona a la mascota.</p>
                    <br>
                    <p>Es muy importante concientizar a todos los miembros de la familia en estabilizar y no cambiar la dieta alimentaria de la mascota. Lo aconsejable es darle de comer después de que la familia haya comido para instaurar la dominancia en el dueño. Si se hace al revés, el perro comenzaría a tener comportamientos dominantes. El lugar donde se le debe poner el plato debe ser tranquilo. Nos debemos asegurar que no se lleve la comida a otro sitio y tampoco quitársela a mitad de la comida, pues provocará ansiedad en el perro, incluso agresividad.</p>
                    <br>
                    <p>Por último, y como es normal, en caso de dudas es recomendable preguntar a nuestro veterinario, que nos puede aconsejar en todo momento de cualquier cuestión que nos surja. Él será el mejor para aconsejarnos a la hora de cambiar la dieta de nuestro perro, si queremos que adelgace algunos kilitos o que engorde otros tantos.</p>
                </section>
            </section>
    <a href="#" class="btn-flotante" id="btnCarrito">Carrito <span class="badge bg-success" id="carrito">0</span></a>
    <!-- Navigation-->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Vida Informático</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <a href="#" class="nav-link text-info" category="all">Todo</a>
                        <?php
                        $query = mysqli_query($conexion, "SELECT * FROM categorias");
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <a href="#" class="nav-link" category="<?php echo $data['categoria']; ?>"><?php echo $data['categoria']; ?></a>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                    $query = mysqli_query($conexion, "SELECT p.*, c.id_categorias, c.categoria FROM productos p INNER JOIN categorias c ON c.id_categorias = p.categoria");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <div class="col mb-5 productos" category="<?php echo $data['categoria']; ?>">
                                <div class="card h-100">
                                    <!-- Sale badge-->
                                    <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem"><?php echo ($data['precio'] > $data['descuento']) ? 'Oferta' : ''; ?></div>
                                    <!-- Product image-->
                                    <img class="card-img-top" src="assets/img/<?php echo $data['imagen']; ?>" alt="..." />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder"><?php echo $data['nombre']; ?></h5>
                                            <p><?php echo $data['descripción']; ?></p>
                                            <!-- Product reviews-->
                                            <div class="d-flex justify-content-center small text-warning mb-2">
                                                <div class="bi-star-fill"></div>
                                                <div class="bi-star-fill"></div>
                                                <div class="bi-star-fill"></div>
                                                <div class="bi-star-fill"></div>
                                                <div class="bi-star-fill"></div>
                                            </div>
                                            <!-- Product price-->
                                            <span class="text-muted text-decoration-line-through"><?php echo $data['precio']; ?></span>
                                            <?php echo $data['descuento']; ?>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto agregar" data-id="<?php echo $data['id_producto']; ?>" href="#">Agregar</a></div>
                                    </div>
                                </div>
                            </div>
                <?php  }
                } ?>

            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5">
        <div class="container">
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
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>