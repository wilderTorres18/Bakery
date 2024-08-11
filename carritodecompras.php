<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require("basededatos/connectionbd.php");

if (isset($_POST['action']) && $_POST['action'] === 'count') {
    echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $producto = obtenerProductoPorId($conn, $id);

    if (!$producto) {
        exit('Producto no encontrado.');
    }

    $idProducto = $id;
    $nombre = $producto['nombre'];
    $precio = $producto['precio'];
    $imagen = $producto['imagen'];
    $encontrado = false;

    if (isset($_SESSION['carrito'])) {
        $arreglo = $_SESSION['carrito'];
        foreach ($arreglo as $key => $item) {
            if ($item['Id'] == $idProducto) {
                $arreglo[$key]['Cantidad']++;
                $encontrado = true;
                break;
            }
        }
    } else {
        $arreglo = [];
    }

    if (!$encontrado) {
        $datosNuevos = array(
            'Id' => $idProducto,
            'Nombre' => $nombre,
            'Precio' => $precio,
            'Imagen' => $imagen,
            'Cantidad' => 1
        );
        array_push($arreglo, $datosNuevos);
    }

    $_SESSION['carrito'] = $arreglo;
}

function obtenerProductoPorId($conn, $id)
{
    $stmt = $conn->prepare("SELECT nombre, precio, imagen FROM catproducto WHERE ID_CATPRODUCTO = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$total = 0;
if (isset($_SESSION['carrito'])) {
    $datos = $_SESSION['carrito'];
    foreach ($datos as $item) {
        $total += $item['Cantidad'] * $item['Precio'];
    }
}
?>

<div class="space-y-4">
    <?php if (isset($_SESSION['carrito'])): ?>
        <?php foreach ($_SESSION['carrito'] as $item): ?>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="carritoindex.php">
                        <img src="./basededatos/<?php echo $item['Imagen']; ?>" class="w-16 h-16 object-cover" alt="<?php echo $item['Nombre']; ?>">
                    </a>
                    <div>
                        <a href="carritoindex.php">
                            <h3 class="text-lg font-semibold text-black hover:text-blue-500"><?php echo $item['Nombre']; ?></h3>
                        </a>
                        <p>Cantidad: <input type="text" value="<?php echo $item['Cantidad']; ?>" data-id="<?php echo $item['Id']; ?>" class="cantidad border rounded w-16 text-center" readonly></p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <p class="text-lg">S/ <?php echo number_format($item['Precio'], 2); ?></p>
                    <button class="eliminar px-4 py-2 bg-red-500 text-white rounded" data-id="<?php echo $item['Id']; ?>">Eliminar</button>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="flex justify-between items-center mt-4">
            <h3 class="text-xl font-bold">Total: S/ <?php echo number_format($total, 2); ?></h3>
            <div class="flex space-x-4">
                <button id="seguirComprando" class="bg-green-500 text-white px-4 py-2 rounded">Seguir Comprando</button>
                <button id="comprar" class="bg-blue-500 text-white px-4 py-2 rounded">Comprar</button>
            </div>
        </div>
    <?php else: ?>
        <p>No has añadido ningún producto.</p>
    <?php endif; ?>
</div>


<script>
    $(document).ready(function() {
        // Eliminar producto
        $(".eliminar").click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'eliminarproducto.php',
                method: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#carritoContent').html(response);
                    updateCartCount();
                }
            });
        });

        // Seguir comprando
        $("#seguirComprando").click(function() {
            $('#carritoModal').addClass('hidden');
        });

        // Comprar
        $("#comprar").click(function() {
            window.location.href = './compras/compras.php';
        });

        function updateCartCount() {
            $.ajax({
                url: 'carritodecompras.php',
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
</script>