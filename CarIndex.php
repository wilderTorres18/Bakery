<?php
session_start();
require(__DIR__ . '/basededatos/connectionbd.php');

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
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Carrito de Compras</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }

        footer {
            flex-shrink: 0;
        }

        .cart-container {
            max-width: 900px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-details,
        .cart-summary {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
        }

        .cart-details {
            width: 60%;
        }

        .cart-summary {
            width: 35%;
        }

        .cart-summary p {
            margin: 5px 0;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .cart-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
        }

        .cart-item div {
            flex: 1;
            margin-left: 10px;
        }

        .cart-item p {
            margin: 0;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <?php include 'navigation.php'; ?>

    <!-- Ajuste de margen superior para la barra de navegación -->
    <div class="main-content mt-8"> <!-- Se añadió la clase mt-8 para el margen superior -->
        <div class="cart-container">
            <!-- Bloque de selección de Método de Envío -->
            <div class="mt-8 p-6 bg-white shadow-md rounded-md">
                <h2 class="text-lg font-bold mb-4">¿Cómo quieres recibir tus productos?</h2>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Opción: Entrega a domicilio -->
                    <div class="flex flex-col items-center p-4 border rounded-md cursor-pointer hover:bg-yellow-100 envio-opcion" data-envio="domicilio">
                        <i class="fas fa-truck text-3xl text-yellow-500 mb-2"></i>
                        <span class="font-medium">Entrega a domicilio</span>
                        <input type="radio" name="metodo_envio" value="domicilio" class="hidden">
                    </div>
                    <!-- Opción: Recojo en tienda -->
                    <div class="flex flex-col items-center p-4 border rounded-md cursor-pointer hover:bg-yellow-100 envio-opcion" data-envio="tienda">
                        <i class="fas fa-store text-3xl text-yellow-500 mb-2"></i>
                        <span class="font-medium">Recojo en tienda</span>
                        <input type="radio" name="metodo_envio" value="tienda" class="hidden">
                    </div>
                </div>
            </div>

            <div class="cart-details">
                <h2 class="text-2xl font-bold mb-4">Carrito de Compras</h2>
                <form action="CarIndex.php" method="post">
                    <?php
                    $total = 0;
                    if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                        foreach ($_SESSION['carrito'] as $item) {
                            $subtotal = $item['Precio'] * $item['Cantidad'];
                            $total += $subtotal;
                    ?>
                            <div class="cart-item">
                                <img src="../basededatos/<?php echo $item['Imagen']; ?>" alt="<?php echo $item['Nombre']; ?>">
                                <div>
                                    <p class="text-lg font-semibold"><?php echo $item['Nombre']; ?></p>
                                    <p class="text-sm text-gray-500">S/ <?php echo number_format($item['Precio'], 2); ?></p>
                                </div>
                                <div>
                                    <input type="number" name="cantidad[<?php echo $item['Id']; ?>]" value="<?php echo $item['Cantidad']; ?>" class="w-12 text-center border rounded">
                                </div>
                                <p class="text-lg font-semibold">S/ <?php echo number_format($subtotal, 2); ?></p>
                                <button type="submit" name="eliminar" value="<?php echo $item['Id']; ?>" class="text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i></button>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<p class="text-center text-gray-600">No hay productos en el carrito.</p>';
                    }
                    ?>
                    <a href="../index.php" class="text-blue-500 hover:underline mt-4 block">← Seguir comprando</a>
            </div>
            <div class="cart-summary">
                <h3 class="text-xl font-bold">Resumen del pedido</h3>
                <div class="mt-4">
                    <p>Items: <?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?></p>
                    <p class="text-lg font-bold">Total: S/ <?php echo number_format($total, 2); ?></p>
                    <button type="submit" name="actualizar" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mt-4">Actualizar</button>
                    <a href="../compras/compras.php" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded mt-4 inline-block">Proceder a pagar</a>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Modal para Entrega a Domicilio -->
    <div id="modal-domicilio" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg w-96 p-6 relative">
            <button onclick="cerrarModal('domicilio')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-bold mb-4">Entrega a Domicilio</h2>
            <p class="text-sm text-gray-600 mb-4">Por favor, confirma tu dirección para la entrega:</p>
            <form>
                <label for="direccion" class="block text-sm font-medium">Dirección:</label>
                <input type="text" id="direccion" class="w-full border rounded px-3 py-2 mb-4" placeholder="Ingrese su dirección">
                <label for="referencia" class="block text-sm font-medium">Referencia:</label>
                <input type="text" id="referencia" class="w-full border rounded px-3 py-2 mb-4" placeholder="Ingrese una referencia (opcional)">
                <div class="mt-4 bg-yellow-100 text-yellow-800 p-3 rounded-md">
                    <p class="text-sm font-semibold">¿Tus datos personales están actualizados?</p>
                    <a href="Perfil.php" class="text-blue-500 hover:underline text-sm">Valida tus datos personales aquí</a>
                </div>
                <button type="button" onclick="cerrarModal('domicilio')" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded mt-4">Confirmar</button>
            </form>
        </div>
    </div>

    <!-- Modal para Recojo en Tienda -->
    <div id="modal-tienda" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg w-96 p-6 relative">
            <button onclick="cerrarModal('tienda')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-bold mb-4">Recojo en Tienda</h2>
            <p class="text-sm text-gray-600 mb-4">Por favor, selecciona la tienda donde deseas recoger tu pedido:</p>
            <form>
                <label for="tienda" class="block text-sm font-medium">Seleccionar tienda:</label>
                <select id="tienda" class="w-full border rounded px-3 py-2 mb-4">
                    <option value="">Seleccione una tienda</option>
                    <option value="tienda1">Tienda 1 - Lima Centro</option>
                    <option value="tienda2">Tienda 2 - Miraflores</option>
                    <option value="tienda3">Tienda 3 - San Isidro</option>
                </select>
                <div class="mt-4 bg-yellow-100 text-yellow-800 p-3 rounded-md">
                    <p class="text-sm font-semibold">¿Tus datos personales están actualizados?</p>
                    <a href="Perfil.php" class="text-blue-500 hover:underline text-sm">Valida tus datos personales aquí</a>
                </div>
                <button type="button" onclick="cerrarModal('tienda')" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded mt-4">Confirmar</button>
            </form>
        </div>
    </div>

    <!--Footer-->
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script>
        // Mostrar modal
        document.querySelectorAll('.envio-opcion').forEach(opcion => {
            opcion.addEventListener('click', function() {
                const tipo = this.getAttribute('data-envio');
                mostrarModal(tipo);
            });
        });

        function mostrarModal(tipo) {
            const modalId = `modal-${tipo}`;
            document.getElementById(modalId).classList.remove('hidden');
        }

        // Cerrar modal
        function cerrarModal(tipo) {
            const modalId = `modal-${tipo}`;
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</body>


</html>