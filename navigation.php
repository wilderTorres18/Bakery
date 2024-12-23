<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$numero_productos = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$nomcl = isset($_SESSION['cl']['nomcl']) ? $_SESSION['cl']['nomcl'] : 'Usuario';
$fotoPerfil = isset($_SESSION['fotoPerfil']) ? $_SESSION['fotoPerfil'] : './img/userYellow2.png';
?>

<!--Navigation-->
<nav class="bg-white">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" 
                        onclick="toggleMobileMenu()"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" 
                        aria-controls="mobile-menu" 
                        aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg id="menu-open-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg id="menu-close-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Logo -->
            <div class="flex-1 flex items-center justify-between sm:items-stretch">
                <a class="navbar-brand flex-shrink-0" href="index.php">
                    <img src="logo.png" width="45" height="90" class="d-inline-block align-top" alt="">
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <a href="index.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                        <a href="tienda.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Tienda</a>
                        <a href="historia.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Historia</a>
                        <a href="establecimiento.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Establecimientos</a>
                        <a href="contacto.php" class="text-white bg-yellow-700 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Contáctanos</a>
                    </div>
                </div>

                <!-- Search Bar - Visible on both mobile and desktop -->
                <div class="flex-1 px-4 flex justify-center">
                    <form id="filterForm" class="w-full max-w-lg">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" 
                                   class="w-full border-2 border-gray-300 bg-white h-10 pl-10 pr-10 rounded-lg text-sm focus:outline-none" 
                                   id="barra-busqueda" 
                                   name="busqueda" 
                                   placeholder="¿Qué se te antoja hoy?" 
                                   value="<?php echo htmlspecialchars($busqueda); ?>">
                            <?php if ($busqueda != ''): ?>
                            <button type="button" 
                                    onclick="clearSearch()" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Desktop Authentication Buttons -->
                    <div class="hidden sm:flex items-center space-x-2">
                        <?php if (!(isset($_SESSION['cl']))) { ?>
                        <a href="nuevo_cliente.php" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md text-sm font-medium">Registrarse</a>
                        <a href="login/" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium">Iniciar sesión</a>
                        <?php } ?>
                    </div>

                    <!-- Shopping Cart -->
                    <a href="../CarIndex.php" id="carrito-btn" class="text-gray-900 hover:text-gray-600 relative">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                            <?php echo $numero_productos; ?>
                        </span>
                    </a>

                    <!-- User Profile -->
                    <?php if (isset($_SESSION['cl'])) { ?>
                    <div class="relative">
                        <div class="flex items-center cursor-pointer" onclick="toggleDropdown()">
                            <img class="w-10 h-10 rounded-full border-2 border-gray-300" src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil">
                            <span class="ml-3 text-gray-700 font-medium hidden sm:block"><?php echo $nomcl ?></span>
                            <i class="fas fa-chevron-down ml-2 text-gray-500 hidden sm:block"></i>
                        </div>
                        <!-- User Dropdown -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg overflow-hidden z-10">
                            <a href="Perfil.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Perfil</a>
                            <a href="verPedido.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Pedidos</a>
                            <div class="border-t border-gray-200"></div>
                            <a href="salir.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Cerrar sesión</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="index.php" class="text-white bg-yellow-700 hover:bg-yellow-600 block px-3 py-2 rounded-md text-base font-medium">Inicio</a>
            <a href="tienda.php" class="text-white bg-yellow-700 hover:bg-yellow-600 block px-3 py-2 rounded-md text-base font-medium">Tienda</a>
            <a href="historia.php" class="text-white bg-yellow-700 hover:bg-yellow-600 block px-3 py-2 rounded-md text-base font-medium">Historia</a>
            <a href="establecimiento.php" class="text-white bg-yellow-700 hover:bg-yellow-600 block px-3 py-2 rounded-md text-base font-medium">Establecimientos</a>
            <a href="contacto.php" class="text-white bg-yellow-700 hover:bg-yellow-600 block px-3 py-2 rounded-md text-base font-medium">Contáctanos</a>
            
            <!-- Mobile Authentication Buttons -->
            <?php if (!(isset($_SESSION['cl']))) { ?>
            <div class="mt-4 space-y-2">
                <a href="nuevo_cliente.php" class="bg-green-500 hover:bg-green-600 text-white block px-3 py-2 rounded-md text-base font-medium">Registrarse</a>
                <a href="login/" class="bg-blue-500 hover:bg-blue-600 text-white block px-3 py-2 rounded-md text-base font-medium">Iniciar sesión</a>
            </div>
            <?php } ?>
        </div>
    </div>
</nav>

<script>
// Toggle mobile menu
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-open-icon');
    const closeIcon = document.getElementById('menu-close-icon');
    
    mobileMenu.classList.toggle('hidden');
    openIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
}

// Toggle user dropdown
function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('hidden');
}

// Clear search function
function clearSearch() {
    document.getElementById('barra-busqueda').value = '';
    document.getElementById('filterForm').submit();
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    const userMenu = document.querySelector('.cursor-pointer');
    
    if (!dropdown.contains(event.target) && !userMenu.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});
</script>
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }
</script>