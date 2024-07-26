<?php
session_start();
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--FontAwesome-->
    <script src="https://kit.fontawesome.com/629388bad9.js" crossorigin="anonymous"></script>

    <!-- Custom favicon for this template-->
    <link rel="icon" type="image/png" href="favicon.png" />

    <title>Panadería "Los Gemelos"</title>
</head>

<body class="bg-gray-100">
    <!--Navigation-->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <a class="navbar-brand flex-shrink-0" href="#">
                        <img src="favicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    </a>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-900 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                            <a href="historia.html" class="text-gray-900 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Historia</a>
                            <a href="contacto.php" class="text-gray-900 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Contáctanos</a>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="flex items-center">
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <?php if (!(isset($_SESSION['cl']))) { ?>
                                <a href="nuevo_cliente.php" class="btn btn-primary my-2 my-sm-0 ">Registrarse</a>
                            <?php } ?>
                        </div>
                        <div class="form-inline my-2 my-lg-0">
                            <?php if (!(isset($_SESSION['cl']))) { ?>
                                <a href="login/" class="btn btn-success my-2 my-sm-0">Iniciar sesión</a>
                            <?php } ?>
                            <?php if (isset($_SESSION['cl'])) { ?>
                                <a href="salir.php" class="btn btn-success my-2 my-sm-0">Salir</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Inicio</a>
                <a href="historia.html" class="text-gray-900 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Historia</a>
                <a href="contacto.php" class="text-gray-900 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Contáctanos</a>
            </div>
        </div>
    </nav>

    <!--Header-->
    <div class="bg-yellow-400 py-12">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-gray-800">"Los Gemelos"</h1>
            <p class="mt-2 text-gray-700">Una panadería en Perú</p>
            <form action="" class="mt-6">
                <input type="text" class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" id="barra-busqueda" placeholder="¿Qué se te antoja hoy?">
            </form>
            <div class="mt-4">
                <a href="#" class="inline-block bg-white text-gray-800 py-2 px-4 rounded-lg shadow hover:bg-gray-200">Todos</a>
                <a href="#" class="inline-block bg-white text-gray-800 py-2 px-4 rounded-lg shadow hover:bg-gray-200">Dulce</a>
                <a href="#" class="inline-block bg-white text-gray-800 py-2 px-4 rounded-lg shadow hover:bg-gray-200">Salado</a>
                <a href="#" class="inline-block bg-white text-gray-800 py-2 px-4 rounded-lg shadow hover:bg-gray-200">Postres</a>
                <a href="#" class="inline-block bg-white text-gray-800 py-2 px-4 rounded-lg shadow hover:bg-gray-200">Tortas</a>
            </div>
        </div>
    </div>

    <!--Grid Productos-->
    <section class="container mx-auto py-8 px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="grid">
        <?php
        require("basededatos/connectionbd.php");
        $query = "SELECT stock, nombre, imagen, sabor, ID_CATPRODUCTO, descripcion, precio FROM catproducto";
        $result = mysqli_query($conn, $query);
        while ($fila = mysqli_fetch_array($result)) {
            $Nom = $fila['nombre'];
            $cod = $fila['precio'];
            $sab = $fila['sabor'];
            $des = $fila['descripcion'];
            $stock = $fila['stock'];
            $id = $fila['ID_CATPRODUCTO'];
            $img = $fila['imagen'];
            if ($stock > 0) {
        ?>
            <div class="bg-white p-4 rounded-lg shadow-lg mt-4" data-categoria="<?php echo $sab; ?>" data-etiquetas="<?php echo $sab; ?> <?php echo $Nom; ?>" data-descripcion="<?php echo $des; ?>">
                <img src="basededatos/<?php echo $img; ?>" alt="<?php echo $Nom; ?>" class="w-full h-48 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-bold text-gray-800"><?php echo $Nom; ?></h2>
                <p class="text-gray-600"><?php echo $des; ?></p>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-gray-800 font-bold">Precio: S/ <?php echo $cod; ?></span>
                    <?php if (isset($_SESSION['cl'])) { ?>
                        <a href="./carritodecompras.php?id=<?php echo $id; ?>" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">Añadir al carrito</a>
                    <?php } ?>
                </div>
            </div>
        <?php  }
        } ?>
    </div>
</section>


    <!--Footer-->
    <footer class="bg-gray-800 py-6 mt-12">
        <div class="container mx-auto text-center text-white">
            <div class="flex justify-center space-x-6 mb-4">
                <a href="#" class="text-white hover:text-gray-400">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-white hover:text-gray-400">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="text-white hover:text-gray-400">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <p>Sitio diseñado por <a href="#" class="underline">WJ SOFTWORKS</a> - <a href="#" class="underline">PIURA - PERU</a></p>
        </div>
    </footer>

    <!--JavaScript-->
    <!--JQuery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>

</html>
