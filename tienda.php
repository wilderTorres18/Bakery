<?php
session_start();
$numero_productos = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/629388bad9.js" crossorigin="anonymous"></script>
    <!-- Custom favicon for this template-->
    <link rel="icon" type="image/png" href="logo.png" />
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/629388bad9.js" crossorigin="anonymous"></script>

    <title>Panadería "Los Gemelos"</title>
</head>

<body class="bg-gray-100">
    <!--Navigation-->
    <?php include 'navigation.php'; ?>
    <!--Header-->
    <div class="bg-yellow-400 py-12 bg-cover bg-center" style="background-image: url('./img/portada.png');">
        <div class="container mx-auto text-center bg-opacity-75 bg-yellow-400 p-4 rounded-lg">
            <h1 class="text-4xl font-bold text-gray-800">"Los Gemelos"</h1>
            <p class="mt-2 text-gray-700">Del horno a tu mesa, frescura y calidad en cada bocado.</p>

            <form id="filterForm" class="relative mt-6 max-w-screen-md mx-auto">
                <div class="relative flex items-center">
                    <span class="absolute left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" class="border-2 border-gray-300 bg-white h-10 pl-10 pr-10 rounded-lg text-sm focus:outline-none w-full" id="barra-busqueda" name="busqueda" placeholder="¿Qué se te antoja hoy?" value="<?php echo htmlspecialchars($busqueda); ?>">
                    <?php if ($busqueda != ''): ?>
                        <span class="absolute right-0 pr-3 flex items-center">
                            <button type="button" id="clearSearch" class="text-gray-400 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </span>
                    <?php endif; ?>
                </div>
                <button type="submit" class="hidden"></button>
            </form>


            <div class="mt-4">
                <button onclick="applyFilter('')" class="inline-block bg-white text-gray-800 py-2 px-4 rounded-lg shadow hover:bg-gray-200">Todos</button>
                <button onclick="applyFilter('Dulce')" class="inline-block bg-white text-gray-800 py-2 px-4 rounded-lg shadow hover:bg-gray-200">Dulce</button>
                <button onclick="applyFilter('Salado')" class="inline-block bg-white text-gray-800 py-2 px-4 rounded-lg shadow hover:bg-gray-200">Salado</button>
            </div>
        </div>
    </div>

    <!--Grid Productos y Carrito de Compras-->
    <div class="container mx-auto py-8 px-8 grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Productos -->
        <div class="lg:col-span-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
            <?php
            require("basededatos/connectionbd.php");
            $sabor = isset($_GET['sabor']) ? $_GET['sabor'] : '';
            $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';


            $query = "SELECT stock, nombre, imagen, sabor, ID_CATPRODUCTO, descripcion, precio, estado FROM catproducto WHERE 1=1";

            // Filtrar por sabor
            if ($sabor != '') {
                $query .= " AND sabor = '" . mysqli_real_escape_string($conn, $sabor) . "'";
            }

            // Filtrar por búsqueda
            if ($busqueda != '') {
                $query .= " AND (nombre LIKE '%" . mysqli_real_escape_string($conn, $busqueda) . "%' OR descripcion LIKE '%" . mysqli_real_escape_string($conn, $busqueda) . "%')";
            }
            // Filtrar por búsqueda
            if ($busqueda != '') {
                $query .= " AND (nombre LIKE '%" . mysqli_real_escape_string($conn, $busqueda) . "%' OR descripcion LIKE '%" . mysqli_real_escape_string($conn, $busqueda) . "%')";
            }

            $result = mysqli_query($conn, $query);
            while ($fila = mysqli_fetch_array($result)) {
                $Nom = $fila['nombre'];
                $cod = $fila['precio'];
                $sab = $fila['sabor'];
                $des = $fila['descripcion'];
                $stock = $fila['stock'];
                $id = $fila['ID_CATPRODUCTO'];
                $img = $fila['imagen'];
                $estado = $fila['estado'];
                if ($stock > 0 && $estado > 0) {
            ?>
                    <div class="bg-white p-4 rounded-lg shadow-lg mt-4" data-categoria="<?php echo $sab; ?>" data-etiquetas="<?php echo $sab; ?> <?php echo $Nom; ?>" data-descripcion="<?php echo $des; ?>">
                        <img src="basededatos/<?php echo $img; ?>" alt="<?php echo $Nom; ?>" class="w-full h-48 object-cover rounded-lg mb-4">
                        <h2 class="text-xl font-bold text-gray-800"><?php echo $Nom; ?></h2>
                        <p class="text-gray-600"><?php echo $des; ?></p>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-gray-800 font-bold">Precio: S/ <?php echo $cod; ?></span>
                            <?php if (isset($_SESSION['cl'])) { ?>
                                <a href="#" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 add-to-cart" data-id="<?php echo $id; ?>">Añadir al carrito</a>
                            <?php } ?>
                        </div>
                    </div>
            <?php  }
            } ?>
        </div>
    </div>

    <!-- Carrito Modal -->
    <div id="carritoModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Carrito de Compras</h2>
                <button class="text-gray-600 hover:text-gray-800" id="closeCarritoModal">&times;</button>
            </div>
            <div id="carritoContent">
                <!-- Contenido del carrito aquí -->
            </div>
        </div>
    </div>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!--Footer-->
    <?php include 'footer.php'; ?>

    <!--JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: './carrito/CarModal.php',
                    method: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $('#carritoContent').html(response);
                        $('#carritoModal').removeClass('hidden');
                        updateCartCount();
                    }
                });
            });

            $('#carrito-btn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: './carrito/CarModal.php',
                    method: 'GET',
                    success: function(response) {
                        $('#carritoContent').html(response);
                        $('#carritoModal').removeClass('hidden');
                    }
                });
            });

            $('#closeCarritoModal').click(function() {
                $('#carritoModal').addClass('hidden');
            });

            function updateCartCount() {
                $.ajax({
                    url: './carrito/CarModal.php',
                    method: 'POST',
                    data: {
                        action: 'count'
                    },
                    success: function(response) {
                        $('#cart-count').text(response);
                    }
                });
            }
        });

        // Aplicar filtro basado en el sabor
        function applyFilter(sabor) {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('sabor', sabor);
            window.location.search = urlParams.toString();
        }

        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const busqueda = document.getElementById('barra-busqueda').value.trim();
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('busqueda', busqueda);
            urlParams.delete('sabor'); // Eliminar el parámetro sabor para hacer una búsqueda sin filtros
            window.location.search = urlParams.toString();
        });

        document.getElementById('clearSearch').addEventListener('click', function() {
            document.getElementById('barra-busqueda').value = '';
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('busqueda');
            window.location.search = urlParams.toString();
        });
    </script>
</body>

</html>