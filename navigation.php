<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$numero_productos = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
?>

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
                <a class="navbar-brand flex-shrink-0" href="index.php">
                    <img src="logo.png" width="45" height="90" class="d-inline-block align-top" alt="">
                </a>
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <a href="index.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                        <a href="tienda.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Tienda</a>
                        <a href="historia.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Historia</a>
                        <a href="establecimiento.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Establecimientos</a>
                        <a href="contacto.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Contáctanos</a>
                    </div>
                </div>
            </div>
            <div class="hidden sm:block">
                <div class="flex items-center">
                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                        <?php if (!(isset($_SESSION['cl']))) { ?>
                            <a href="nuevo_cliente.php" class="btn bg-green-500 hover:bg-green-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Registrarse</a>
                        <?php } ?>
                    </div>
                    <div class="form-inline my-2 my-lg-0">
                        <?php if (!(isset($_SESSION['cl']))) { ?>
                            <a href="login/" class="btn bg-blue-500 hover:bg-blue-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Iniciar sesión</a>
                        <?php } ?>
                        <?php if (isset($_SESSION['cl'])) { ?>
                            <a href="salir.php" class="btn bg-red-500 hover:bg-red-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Salir</a>
                        <?php } ?>
                    </div>
                    <a href="./carrito/CarIndex.php" id="carrito-btn" class="ml-4 text-gray-900 hover:text-gray-600 relative">
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
            <a href="index.php" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Inicio</a>
            <a href="tienda.php" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Tienda</a>
            <a href="historia.php" class="text-gray-900 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Historia</a>
            <a href="establecimiento.php" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Establecimientos</a>
            <a href="contacto.php" class="text-gray-900 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Contáctanos</a>
        </div>
    </div>
</nav>