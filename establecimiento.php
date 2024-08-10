<?php
session_start();
$numero_productos = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
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

    <title>Panadería "Los Gemelos"</title>
    <style>
        .banner-section {
            position: relative;
            background-image: url('img/banner.png'); /* Reemplaza con la ruta de tu imagen */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 2rem 0;
            text-align: center;
            color: white;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Ajusta la transparencia aquí */
        }

        .banner-content {
            position: relative;
            z-index: 1;
        }
    </style>
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
                        <img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    </a>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="index.php"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                                <a href="tienda.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Tienda</a>
                            <a href="historia.html"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Historia</a>

                            <a href="establecimiento.php"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Establecimientos</a>
                            <a href="contacto.php"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Contáctanos</a>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="flex items-center">
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <?php if (!(isset($_SESSION['cl']))) { ?>
                            <a href="nuevo_cliente.php"
                                class="btn bg-green-500 hover:bg-green-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Registrarse</a>
                            <?php } ?>
                        </div>
                        <div class="form-inline my-2 my-lg-0">
                            <?php if (!(isset($_SESSION['cl']))) { ?>
                            <a href="login/"
                                class="btn bg-blue-500 hover:bg-blue-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Iniciar
                                sesión</a>
                            <?php } ?>
                            <?php if (isset($_SESSION['cl'])) { ?>
                            <a href="salir.php"
                                class="btn bg-red-500 hover:bg-red-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Salir</a>
                            <?php } ?>
                        </div>
                        <a href="carritoindex.php" id="carrito-btn" class="ml-4 text-gray-900 hover:text-gray-600 relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-count" class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center"><?php echo $numero_productos; ?></span>
                        </a>
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

    <!-- Establecimientos -->
    <section class="py-16 bg-gray-100">
        <div class="banner-section">
            <div class="banner-overlay"></div>
            <div class="banner-content">
                <div class="text-center">
                    <h2 class="text-4xl font-bold text-white">Nuestros Establecimientos</h2>
                    <p class="mt-4 text-white">Conoce nuestras ubicaciones y visítanos en nuestras tiendas.</p>
                </div>
            </div>
        </div>
        <div class="container mx-auto px-6 mt-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img class="w-full h-64 object-cover rounded-t-lg" src="img/establecimiento1.jpg" alt="Establecimiento 1">
                    <div class="p-4">
                        <h3 class="text-2xl font-bold text-gray-800">Calle Vernal Cuadra 4 - Bellavista</h3>
                        <p class="mt-2 text-gray-600">Número: 942720461</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <img class="w-full h-64 object-cover rounded-t-lg" src="img/establecimiento2.jpg" alt="Establecimiento 2">
                    <div class="p-4">
                        <h3 class="text-2xl font-bold text-gray-800">Calle Victor Raúl - Bellavista</h3>
                        <p class="mt-2 text-gray-600">Número: 942720461</p>
                    </div>
                </div>
            </div>
            <div class="mt-10 text-center">
                <h3 class="text-3xl font-bold text-gray-800">Ubicación</h3>
                <div class="flex justify-center mt-4">
                    <!-- Aquí se inserta el mapa de Google Maps -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.284067843343!2d-80.7588793!3d-5.5713565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x902b9bfa58f50ffb%3A0x3ec408e19f74ae0e!2sSullana%2C%20Per%C3%BA!5e0!3m2!1ses!2sus!4v1628082079984!5m2!1ses!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?> 

    <!-- Footer -->
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
            <p>Sitio diseñado por <a href="#" class="underline">2024</a> - <a href="#" class="underline">software </a></p>
        </div>
    </footer>

    <!--JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
</body>

</html>
