$(document).ready(function () {
    let productos = [];
    let items = {
        id: 0
    };
    mostrar();
    $('.navbar-nav .nav-link[category="all"]').addClass('active');

    $('.nav-link').click(function () {
        let productos = $(this).attr('category');

        $('.nav-link').removeClass('active');
        $(this).addClass('active');

        $('.productos').css('transform', 'scale(0)');

        function ocultar() {
            $('.productos').hide();
        }
        setTimeout(ocultar, 400);

        function mostrar() {
            $('.productos[category="' + productos + '"]').show();
            $('.productos[category="' + productos + '"]').css('transform', 'scale(1)');
        }
        setTimeout(mostrar, 400);
    });

    $('.nav-link[category="all"]').click(function () {
        function mostrarTodo() {
            $('.productos').show();
            $('.productos').css('transform', 'scale(1)');
        }
        setTimeout(mostrarTodo, 400);
    });

    $('.agregar').click(function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        items = {
            id: id
        };
        productos.push(items);
        localStorage.setItem('productos', JSON.stringify(productos));
        mostrar();
    });

    $('#btnCarrito').click(function (e) {
        $('#btnCarrito').attr('href', 'carrito.php');
    });

    $('#btnVaciar').click(function () {
        localStorage.removeItem("productos");
        $('#tblCarrito').html('');
        $('#total_pagar').text('0.00');
    });

    // Abrir Modal de Categorías
    $('#abrirCategoria').click(function () {
        $('#categorias').modal('show');
    });

    // Abrir Modal de Productos
    $('#abrirProducto').click(function () {
        $('#productos').modal('show');
    });

    // Abrir Modal de Clientes
    $('#abrirClientes').click(function () {
        $('#clientes').modal('show');
    });

    // Abrir Modal de Mascota
    $('#abrirmascota').click(function () {
        $('#mascotas').modal('show');
    });

    // Abrir Modal de Vacuna
    $('#abrirvacuna').click(function () {
        $('#aplicacion').modal('show');
    });

    // Confirmar eliminación
    $('.eliminar').click(function (e) {
        e.preventDefault();
        if (confirm('¿Está seguro de eliminar?')) {
            this.submit();
        }
    });

    // Mostrar el número de productos en el carrito
    function mostrar() {
        if (localStorage.getItem("productos") != null) {
            let array = JSON.parse(localStorage.getItem('productos'));
            if (array) {
                $('#carrito').text(array.length);
            }
        }
    }

    // Llenar formulario del modal con los datos seleccionados
    $('.edit-btn').click(function() {
        var id_mascota = $(this).data('id');
        var codigo = $(this).data('codigo');
        var nombre = $(this).data('nombre');
        var tipo = $(this).data('tipo');
        var genero = $(this).data('genero');
        var raza = $(this).data('raza');

        // Asignamos los valores al formulario del modal
        $('#id_mascota').val(id_mascota);
        $('#editCodigo').val(codigo);
        $('#editNombreMascota').val(nombre);
        $('#editTipo').val(tipo);
        $('#editGenero').val(genero);
        $('#editRaza').val(raza);
    });
});

// Llenar formulario del modal con los datos seleccionados de cliente
$('.edit-btn').click(function() {
    var id_cliente = $(this).data('id');
    var nombre = $(this).data('nombre');
    var apellido = $(this).data('apellido');
    var cedula = $(this).data('cedula');
    var correo_e = $(this).data('correo_e');
    var telefono = $(this).data('telefono');

    // Asignamos los valores al formulario del modal
    $('#id_cliente').val(id_cliente);
    $('#editNombre').val(nombre);
    $('#editApellido').val(apellido);
    $('#editCedula').val(cedula);
    $('#editCorreoE').val(correo_e);
    $('#editTelefono').val(telefono);
});
