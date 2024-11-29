<?php
session_start();

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

if (isset($_POST['confirmar_envio'])) {
    $_SESSION['envio'] = [
        'metodo' => $_POST['metodo_envio'],
        'direccion' => $_POST['direccion'] ?? null,
        'referencia' => $_POST['referencia'] ?? null,
        'fecha_recojo' => $_POST['fecha_recojo'] ?? null,
        'hora_recojo' => $_POST['hora_recojo'] ?? null,
    ];
    // Redirigir o procesar el siguiente paso
    header("Location: CarIndex.php"); // Redirigir al mismo lugar para mostrar el cambio
    exit;
}


if (isset($_POST['eliminar_envio']) && $_POST['eliminar_envio'] === 'true') {
    unset($_SESSION['envio']);
    header("Location: CarIndex.php"); // Redirigir para actualizar la página
    exit;
}

/* echo "<pre>";
var_dump($_SESSION['envio']);
echo "</pre>";
 */
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

    <div class="main-content mt-8 flex flex-col items-center">
        <!-- Carrito de Compras -->
        <div class="cart-container w-full max-w-4xl px-4 py-6 bg-white shadow-md rounded-md mb-8">
            <div class="cart-details">
                <h2 class="text-2xl font-bold mb-4 text-center">Carrito de Compras</h2>
                <form action="CarIndex.php" method="post">
                    <?php
                    $total = 0;
                    if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                        foreach ($_SESSION['carrito'] as $item) {
                            $subtotal = $item['Precio'] * $item['Cantidad'];
                            $total += $subtotal;
                    ?>
                            <div class="cart-item flex justify-between items-center py-4 border-b border-gray-300">
                                <div class="flex items-center">
                                    <img src="../basededatos/<?php echo $item['Imagen']; ?>" alt="<?php echo $item['Nombre']; ?>" class="w-16 h-16 mr-4">
                                    <div>
                                        <p class="text-lg font-semibold"><?php echo $item['Nombre']; ?></p>
                                        <p class="text-sm text-gray-500">S/ <?php echo number_format($item['Precio'], 2); ?></p>
                                    </div>
                                </div>
                                <div>
                                    <input type="number" name="cantidad[<?php echo $item['Id']; ?>]" value="<?php echo $item['Cantidad']; ?>" class="w-12 text-center border rounded-md">
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

            <div class="cart-summary mt-6">
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

        <!-- Carta de Envío de Pedidos (centrada en la parte inferior) -->
        <div class="w-full max-w-4xl px-4 py-6 bg-white shadow-md rounded-md mt-8 mb-4">
            <h2 class="text-lg font-bold mb-4 text-center">¿Cómo quieres recibir tus productos?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col items-center p-6 border rounded-md cursor-pointer hover:bg-yellow-100 envio-opcion" data-envio="domicilio">
                    <i class="fas fa-truck text-3xl text-yellow-500 mb-2"></i>
                    <span class="font-medium">Entrega a domicilio</span>
                    <input type="radio" name="metodo_envio" value="domicilio" class="hidden">
                </div>
                <div class="flex flex-col items-center p-6 border rounded-md cursor-pointer hover:bg-yellow-100 envio-opcion" data-envio="tienda">
                    <i class="fas fa-store text-3xl text-yellow-500 mb-2"></i>
                    <span class="font-medium">Recojo en tienda</span>
                    <input type="radio" name="metodo_envio" value="tienda" class="hidden">
                </div>
            </div>
        </div>
    </div>


    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!--Footer-->
    <?php include 'footer.php'; ?>
    <!-- Modal para Entrega a Domicilio -->
    <div id="modal-domicilio" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg w-96 p-6 relative">
            <button onclick="cerrarModal('domicilio')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-bold mb-4">Entrega a Domicilio</h2>
            <form action="CarIndex.php" method="post">
                <input type="hidden" name="metodo_envio" value="domicilio">
                <label for="direccion" class="block text-sm font-medium">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="w-full border rounded px-3 py-2 mb-4" placeholder="Ingrese su dirección" required>

                <label for="referencia" class="block text-sm font-medium">Referencia:</label>
                <input type="text" id="referencia" name="referencia" class="w-full border rounded px-3 py-2 mb-4" placeholder="Ingrese una referencia (opcional)">

                <div class="mt-4 bg-yellow-100 text-yellow-800 p-3 rounded-md">
                    <p class="text-sm font-semibold">¿Tus datos personales están actualizados?</p>
                    <a href="Perfil.php" class="text-blue-500 hover:underline text-sm">Valida tus datos personales aquí</a>
                </div>
                <button type="submit" name="confirmar_envio" class="mt-4 py-2 px-4 bg-green-500 text-white rounded">Confirmar envio</button>
                <button type="button" onclick="eliminarMetodoEnvio()" class="mt-4 py-2 px-4 bg-red-500 text-white rounded">Eliminar Método de Envío</button>
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
            <form action="CarIndex.php" method="post">
                <input type="hidden" name="metodo_envio" value="tienda">
                <label for="fecha-recojo" class="block text-sm font-medium">Fecha de Recojo:</label>
                <input type="date" id="fecha-recojo" name="fecha_recojo" class="w-full border rounded px-3 py-2 mb-4" required>

                <label for="hora-recojo" class="block text-sm font-medium">Hora de Recojo:</label>
                <input type="time" id="hora-recojo" name="hora_recojo" class="w-full border rounded px-3 py-2 mb-4" required>

                <div class="mt-4 bg-yellow-100 text-yellow-800 p-3 rounded-md">
                    <p class="text-sm font-semibold">¿Tus datos personales están actualizados?</p>
                    <a href="Perfil.php" class="text-blue-500 hover:underline text-sm">Valida tus datos personales aquí</a>
                </div>
                <button type="submit" name="confirmar_envio" class="mt-4 py-2 px-4 bg-green-500 text-white rounded">Confirmar recojo</button>
                <button type="button" onclick="eliminarMetodoEnvio()" class="mt-4 py-2 px-4 bg-red-500 text-white rounded">Eliminar Método de Envío</button>
            </form>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const envioDomicilio = document.querySelector('[data-envio="domicilio"]');
            const envioTienda = document.querySelector('[data-envio="tienda"]');
            const btnPagar = document.querySelector('[href="../compras/compras.php"]'); // Enlace "Pagar"
            const cantidades = document.querySelectorAll('input[type="number"]'); // Campos de cantidad

            // Función para cerrar el modal
            function cerrarModal(tipo) {
                const modal = document.getElementById(`modal-${tipo}`);
                if (modal) {
                    modal.classList.add('hidden'); // Ocultar el modal
                    console.log(`Modal ${tipo} cerrado`);
                } else {
                    console.log(`Modal ${tipo} no encontrado para cerrar`);
                }
            }

            // Función para abrir el modal correspondiente
            function abrirModal(tipo) {
                const modal = document.getElementById(`modal-${tipo}`);
                if (modal) {
                    modal.classList.remove('hidden');
                    console.log(`Modal ${tipo} abierto`);

                    // Mostrar los datos guardados en la sesión
                    if (tipo === 'domicilio') {
                        const fechaDomicilio = <?php echo json_encode($_SESSION['envio']['fecha_recojo'] ?? ''); ?>;
                        const horaDomicilio = <?php echo json_encode($_SESSION['envio']['hora_recojo'] ?? ''); ?>;
                        const direccionDomicilio = <?php echo json_encode($_SESSION['envio']['direccion'] ?? ''); ?>;
                        const referenciaDomicilio = <?php echo json_encode($_SESSION['envio']['referencia'] ?? ''); ?>;

                        if (fechaDomicilio) document.getElementById('fecha-recojo').value = fechaDomicilio;
                        if (horaDomicilio) document.getElementById('hora-recojo').value = horaDomicilio;
                        if (direccionDomicilio) document.getElementById('direccion').value = direccionDomicilio;
                        if (referenciaDomicilio) document.getElementById('referencia').value = referenciaDomicilio;
                    }

                    if (tipo === 'tienda') {
                        const fechaTienda = <?php echo json_encode($_SESSION['envio']['fecha_recojo'] ?? ''); ?>;
                        const horaTienda = <?php echo json_encode($_SESSION['envio']['hora_recojo'] ?? ''); ?>;

                        if (fechaTienda) document.getElementById('fecha-recojo').value = fechaTienda;
                        if (horaTienda) document.getElementById('hora-recojo').value = horaTienda;
                    }
                } else {
                    console.log(`Modal ${tipo} no encontrado para abrir`);
                }
            }

            // Verificar si ya se ha seleccionado un método de envío y actualizar la interfaz
            const metodoEnvio = <?php echo isset($_SESSION['envio']) ? json_encode($_SESSION['envio']['metodo']) : 'null'; ?>;
            console.log('Método de envío seleccionado:', metodoEnvio);

            if (metodoEnvio === 'domicilio') {
                envioTienda.classList.add('pointer-events-none'); // Deshabilitar el botón de Recojo en Tienda
                envioTienda.classList.add('bg-gray-300'); // Cambiar el color del botón
                abrirModal('domicilio'); // Abrir modal de domicilio si ya se seleccionó
            } else if (metodoEnvio === 'tienda') {
                envioDomicilio.classList.add('pointer-events-none'); // Deshabilitar el botón de Entrega a Domicilio
                envioDomicilio.classList.add('bg-gray-300'); // Cambiar el color del botón
                abrirModal('tienda'); // Abrir modal de tienda si ya se seleccionó
            }

            // Asignar eventos para abrir los modales
            envioDomicilio.addEventListener('click', function() {
                console.log('Intentando abrir el modal de Domicilio');
                if (!envioDomicilio.classList.contains('pointer-events-none')) {
                    abrirModal('domicilio');
                }
            });

            envioTienda.addEventListener('click', function() {
                console.log('Intentando abrir el modal de Tienda');
                if (!envioTienda.classList.contains('pointer-events-none')) {
                    abrirModal('tienda');
                }
            });

            // Asignar evento para cerrar el modal usando addEventListener
            const cerrarTienda = document.querySelector('[onclick="cerrarModal(\'tienda\')"]');
            const cerrarDomicilio = document.querySelector('[onclick="cerrarModal(\'domicilio\')"]');

            if (cerrarTienda) {
                cerrarTienda.addEventListener('click', function() {
                    cerrarModal('tienda');
                });
            }

            if (cerrarDomicilio) {
                cerrarDomicilio.addEventListener('click', function() {
                    cerrarModal('domicilio');
                });
            }

            // Función para eliminar el método de envío
            function eliminarMetodoEnvio() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'CarIndex.php';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'eliminar_envio';
                input.value = 'true';

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }

            // Validar si se seleccionó un método de envío para habilitar el enlace "Pagar"
            function validarMetodoEnvio() {
                if (metodoEnvio !== null) {
                    btnPagar.classList.remove('pointer-events-none');
                    btnPagar.classList.remove('bg-gray-300');
                    btnPagar.classList.add('bg-green-500'); // Cambiar a color habilitado
                    btnPagar.href = '../compras/compras.php'; // Habilitar enlace
                } else {
                    btnPagar.classList.add('pointer-events-none');
                    btnPagar.classList.add('bg-gray-300');
                    btnPagar.classList.remove('bg-green-500'); // Asegurarse de que no esté verde
                    btnPagar.href = '#'; // Deshabilitar enlace
                }
            }

            // Llamamos a la validación inicial
            validarMetodoEnvio();

            // Revalidar el enlace de pagar cada vez que se cambie el método de envío
            const metodoEnvioElements = document.querySelectorAll('[data-envio]');
            metodoEnvioElements.forEach(function(element) {
                element.addEventListener('click', function() {
                    // Verificar que el valor de metodoEnvio cambió
                    validarMetodoEnvio();
                });
            });

            // Manejar el click en el enlace "Pagar"
            btnPagar.addEventListener('click', function(event) {
                if (metodoEnvio === null) {
                    // Evitar que el enlace funcione si no se ha seleccionado un método de envío
                    event.preventDefault();
                    // Mostrar SweetAlert si no se ha seleccionado un método de envío
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Atención!',
                        text: 'Debes seleccionar un método de envío antes de proceder al pago.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });

            // Validación para evitar valores negativos en las cantidades
            cantidades.forEach(function(input) {
                input.addEventListener('input', function() {
                    if (parseInt(input.value) < 0) {
                        input.value = 0; // Si es negativo, lo dejamos en 0
                        alert('La cantidad no puede ser negativa');
                    }
                });
            });
        });
    </script>



</body>

</html>