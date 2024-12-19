<?php
session_start();
require("./basededatos/connectionbd.php");

if (!isset($_SESSION['cl'])) {
    header("Location: index.php");
    exit;
}

$dni_cl = $_SESSION['cl']['dnicl'];
if (isset($_GET['cod_ped'])) {
    $cod_ped = $_GET['cod_ped'];

    // Consulta para obtener los productos del pedido
    $query = "
    SELECT p.*, c.nombre, c.imagen
    FROM pedidos p
    INNER JOIN catproducto c ON p.cod_pro = c.ID_CATPRODUCTO
    WHERE p.dni_cl = ? AND p.cod_ped = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $dni_cl, $cod_ped);
    $stmt->execute();
    $result = $stmt->get_result();

    // Consulta para obtener los detalles de envío/recojo
    $query2 = "
    SELECT dir_ped, est_ped, referencia_opc, tipo_envio, fecha_recojo, hora_recojo
    FROM pedidos
    WHERE cod_ped = ? AND dni_cl = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("ss", $cod_ped, $dni_cl);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $detallesEnvio = $result2->fetch_assoc(); // Obtener los detalles de envío
} else {
    header("Location: verPedido.php");
    exit();
}
// Acumulador para el total
$totalPedido = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Realizado Correctamente</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-corporativo {
            background-color: #a25627;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Navigation -->
    <?php include 'navigation.php'; ?>

    <!-- Contenido Principal -->
    <main class="container mx-auto my-6 p-8 bg-white shadow-xl rounded-lg max-w-5xl">

        <h1 class="text-2xl font-semibold text-center mb-6">Pedido Realizado Correctamente</h1>

        <!-- Productos en tarjetas ajustadas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($pedido = $result->fetch_assoc()): ?>
                    <div class="flex flex-col items-center p-4 bg-gray-50 shadow rounded-lg hover:shadow-md transition">
                        <!-- Imagen -->
                        <div class="w-16 h-16 mb-2">
                            <img src="basededatos/<?php echo $pedido['imagen']; ?>" alt="Producto" class="w-full h-full object-cover rounded">
                        </div>
                        <!-- Nombre del Pedido -->
                        <p class="text-gray-800 font-semibold text-center mb-2"><?php echo $pedido['nombre']; ?></p>
                        <!-- Detalles -->
                        <div class="text-center text-sm">
                            <p class="text-gray-700"><span class="font-semibold">Total:</span> S/ <?php echo number_format($pedido['total'], 2); ?></p>
                            <p class="text-gray-700"><span class="font-semibold">Fecha:</span> <?php echo date("d/m/Y", strtotime($pedido['Fec_ped'])); ?></p>
                        </div>
                    </div>
                    <?php
                    // Acumular el total del pedido
                    $totalPedido += $pedido['total'];
                    ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-gray-600">No hay detalles disponibles para este pedido.</p>
            <?php endif; ?>
        </div>
        <!-- Mostrar el total del pedido al final -->
        <div class="mt-4 flex justify-between items-center p-4 bg-gray-50 shadow rounded-lg">
            <p class="text-xl font-semibold text-gray-800">Total del Pedido:</p>
            <p class="text-xl font-bold text-gray-700">S/ <?php echo number_format($totalPedido, 2); ?></p>
        </div>

        <?php if ($detallesEnvio): ?>
            <!-- Datos de Envío/Recojo -->
            <div class="mt-6 p-3 bg-gray-100 rounded shadow">
                <h2 class="text-gray-800 font-semibold mb-3">Datos de Envío/Recojo</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <p class="text-gray-700">
                        <span class="font-semibold">Dirección:</span>
                        <?php echo isset($detallesEnvio['dir_ped']) && $detallesEnvio['dir_ped'] ? htmlspecialchars($detallesEnvio['dir_ped']) : 'No disponible'; ?>
                    </p>
                    <p class="text-gray-700">
                        <span class="font-semibold">Estado del Pedido:</span>
                        <?php echo isset($detallesEnvio['est_ped']) && $detallesEnvio['est_ped'] ? htmlspecialchars($detallesEnvio['est_ped']) : 'No disponible'; ?>
                    </p>
                    <p class="text-gray-700">
                        <span class="font-semibold">Referencia Opcional:</span>
                        <?php echo isset($detallesEnvio['referencia_opc']) && $detallesEnvio['referencia_opc'] ? htmlspecialchars($detallesEnvio['referencia_opc']) : 'No disponible'; ?>
                    </p>
                    <p class="text-gray-700">
                        <span class="font-semibold">Tipo de Envío:</span>
                        <?php echo isset($detallesEnvio['tipo_envio']) && $detallesEnvio['tipo_envio'] ? htmlspecialchars($detallesEnvio['tipo_envio']) : 'No disponible'; ?>
                    </p>
                    <p class="text-gray-700">
                        <span class="font-semibold">Fecha de Recojo:</span>
                        <?php echo isset($detallesEnvio['fecha_recojo']) && $detallesEnvio['fecha_recojo'] ? date("d/m/Y", strtotime($detallesEnvio['fecha_recojo'])) : 'No disponible'; ?>
                    </p>
                    <p class="text-gray-700">
                        <span class="font-semibold">Hora de Recojo:</span>
                        <?php echo isset($detallesEnvio['hora_recojo']) && $detallesEnvio['hora_recojo'] ? htmlspecialchars($detallesEnvio['hora_recojo']) : 'No disponible'; ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Descargar Ticket -->
        <div class="text-right mt-4">
            <a href="generar_ticket.php?cod_ped=<?php echo $cod_ped; ?>" class="bg-corporativo hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded transition">
                Generar Ticket
            </a>
        </div>

        <!-- Botón de regreso -->
        <div class="mt-4">
            <a href="verPedido.php" class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded transition duration-300">
                ← Regresar a Mis Pedidos
            </a>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 text-center">
        <p class="text-sm">Sitio diseñado por <a href="#" class="text-blue-400 hover:underline">WJ SOFTWORKS</a> - PIURA - PERU</p>
    </footer>

</body>

</html>