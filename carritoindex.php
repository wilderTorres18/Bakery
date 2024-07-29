<?php
session_start();
require("basededatos/connectionbd.php");

// Eliminar producto del carrito
if (isset($_POST['eliminar'])) {
    $id = $_POST['eliminar'];
    foreach ($_SESSION['carrito'] as $key => $item) {
        if ($item['Id'] == $id) {
            unset($_SESSION['carrito'][$key]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
            break;
        }
    }
}

// Actualizar cantidades de productos en el carrito
if (isset($_POST['actualizar'])) {
    foreach ($_POST['cantidad'] as $id => $cantidad) {
        foreach ($_SESSION['carrito'] as $key => $item) {
            if ($item['Id'] == $id) {
                $_SESSION['carrito'][$key]['Cantidad'] = $cantidad;
            }
        }
    }
}
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
    <title>Carrito de Compras</title>
</head>
<body class="bg-gray-100">
    <!--Navigation-->
    <nav class="bg-white shadow-md mb-8">
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
                            <a href="index.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                            <a href="historia.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Historia</a>
                            <a href="establecimiento.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Establecimientos</a>
                            <a href="contacto.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Contáctanos</a>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="flex items-center">
                        <a href="carritoindex.php" id="carrito-btn" class="ml-4 text-gray-900 hover:text-gray-600 relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="ml-1 bg-red-500 text-white rounded-full px-2 py-1 text-xs absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2"><?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Carrito de Compras -->
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Carrito de compras</h1>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="carritoindex.php" method="post">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Imagen</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Producto</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Precio</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cantidad</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                            foreach ($_SESSION['carrito'] as $item) {
                                $subtotal = $item['Precio'] * $item['Cantidad'];
                                $total += $subtotal;
                        ?>
                        <tr class="bg-white border-b">
                            <td class="px-4 py-4 text-sm">
                                <img src="basededatos/<?php echo $item['Imagen']; ?>" alt="<?php echo $item['Nombre']; ?>" class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <p class="text-gray-900"><?php echo $item['Nombre']; ?></p>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <p class="text-gray-900">S/ <?php echo number_format($item['Precio'], 2); ?></p>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <input type="number" name="cantidad[<?php echo $item['Id']; ?>]" value="<?php echo $item['Cantidad']; ?>" class="w-12 text-center border rounded">
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <p class="text-gray-900">S/ <?php echo number_format($subtotal, 2); ?></p>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <button type="submit" name="eliminar" value="<?php echo $item['Id']; ?>" class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" class="px-5 py-5 text-sm text-center text-gray-600">No hay productos en el carrito.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="flex justify-between items-center mt-6 px-5 py-3 border-t">
                    <span class="text-xl font-bold">Total: S/ <?php echo number_format($total, 2); ?></span>
                    <div>
                        <a href="index.php" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">Seguir comprando</a>
                        <button type="submit" name="actualizar" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Actualizar</button>
                        <a href="compras/compras.php" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Proceder a pagar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
