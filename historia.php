<?php
session_start();
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
                            <a href="index.php"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
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
                        <a href="carrito.php" class="ml-4 text-gray-900 hover:text-gray-600">
                            <i class="fas fa-shopping-cart"></i>
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

<!-- Quiénes Somos -->
<section class="py-2 bg-gray-100">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="order-2 lg:order-1">
                <div class="p-5">
                    <h2 class="text-3xl font-bold text-gray-800">¿Quiénes somos?</h2>
                    <p class="mt-4 text-gray-600">Somos "Los Gemelos", una empresa que nació en 2021 en la provincia de Sullana con el objetivo de satisfacer las necesidades de nuestros clientes con productos de alta calidad. Contamos con dos tiendas físicas ubicadas en la calle Benal y en la calle Víctor Raúl. Para expandir nuestra presencia y llegar a más clientes, hemos creado una página web. Nuestros clientes confían en nosotros por la variedad y calidad de nuestros panes.</p>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <div class="p-5">
                    <img class="w-full h-auto rounded-lg shadow-lg" src="img/somos.jpg" alt="¿Quiénes somos?">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Misión -->
<section class="py-2 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div>
                <div class="p-5">
                    <img class="w-full h-auto rounded-lg shadow-lg" src="img/mision.jpg" alt="Misión">
                </div>
            </div>
            <div>
                <div class="p-5">
                    <h2 class="text-3xl font-bold text-gray-800">Misión</h2>
                    <p class="mt-4 text-gray-600">Nuestra misión es hornear productos de la mejor calidad y frescura todos los días. Nos esforzamos por ofrecer una amplia variedad de panes que destacan por sus ingredientes de primera calidad. Además, facilitamos la entrega a domicilio para asegurar un servicio excelente y satisfacer a nuestra clientela.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visión -->
<section class="py-2 bg-gray-100">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="order-2 lg:order-1">
                <div class="p-5">
                    <h2 class="text-3xl font-bold text-gray-800">Visión</h2>
                    <p class="mt-4 text-gray-600">Nuestra visión es ser líderes en la industria panificadora, reconocidos por la excelencia de nuestros productos y el servicio excepcional que brindamos a nuestros clientes.</p>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <div class="p-5">
                    <img class="w-full h-auto rounded-lg shadow-lg" src="img/vision.jpg" alt="Visión">
                </div>
            </div>
        </div>
    </div>
</section>


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
            <p>Sitio diseñado por <a href="#" class="underline">Deportivo Tapitas</a> - <a href="#" class="underline">Universidad de Cundinamarca</a></p>
        </div>
    </footer>

    <!--JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
</body>

</html>
