<?php
session_start();
require("./basededatos/connectionbd.php");

if (!isset($_SESSION['cl'])) {
    // Redirigir al login si el usuario no está logueado
    header("Location: index.php");
    exit;
}

$numero_productos = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;

// Obtener el dni_cl del cliente logueado
$dni_cl = $_SESSION['cl']['dnicl'];

// Obtener la fecha filtrada si existe
$fecha_filtro = isset($_GET['fecha']) ? $_GET['fecha'] : '';

// Configuración de paginación
$pedidos_por_pagina = 8;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $pedidos_por_pagina;

// Consulta para obtener los pedidos del cliente con paginación
$query = "SELECT 
            cod_ped, 
            MAX(Fec_ped) AS Fec_ped, 
            MAX(est_ped) AS estado_pedido, 
            SUM(total) AS total,
            MAX(tipo_envio) AS tipo_envio
          FROM pedidos 
          WHERE dni_cl = ? 
          " . ($fecha_filtro ? "AND Fec_ped LIKE ?" : "") . "
          GROUP BY cod_ped
          LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
if ($fecha_filtro) {
    $fecha_filtro = "%" . $fecha_filtro . "%";  // Preparar filtro para fecha
    // Cambiar la cadena de tipos a 'ssss' cuando haya filtro de fecha
    $stmt->bind_param("ssss", $dni_cl, $fecha_filtro, $pedidos_por_pagina, $offset);
} else {
    // Cambiar la cadena de tipos a 'sii' cuando no haya filtro de fecha
    $stmt->bind_param("sii", $dni_cl, $pedidos_por_pagina, $offset);
}
$stmt->execute();
$result = $stmt->get_result();


// Consulta para obtener el total de pedidos (sin límite)
$query_total = "SELECT COUNT(*) AS total_pedidos FROM pedidos WHERE dni_cl = ?" . ($fecha_filtro ? " AND Fec_ped LIKE ?" : "");
$stmt_total = $conn->prepare($query_total);
if ($fecha_filtro) {
    $stmt_total->bind_param("ss", $dni_cl, $fecha_filtro);
} else {
    $stmt_total->bind_param("s", $dni_cl);
}
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_pedidos = $total_result->fetch_assoc()['total_pedidos'];
$total_paginas = ceil($total_pedidos / $pedidos_por_pagina);
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

    <title>Panadería "Los Gemelos"</title>
</head>

<body class="bg-gray-100">

    <!-- Navigation -->
    <?php include 'navigation.php'; ?>

    <div class="container mx-auto my-10 p-5 bg-white shadow-md rounded-md">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Mis Pedidos</h1>

        <!-- Mensaje de validación de pago -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
            <strong>Nota:</strong> Una vez confirmado, procederemos a preparar tu pedido y actualizar su estado. ¡Gracias por tu compra!
        </div>

        <!-- Filtro por fecha -->
        <form method="get" class="mb-6">
            <div class="flex justify-center items-center space-x-4">
                <input type="date" name="fecha" value="<?php echo htmlspecialchars($fecha_filtro); ?>" class="p-2 border rounded-md" placeholder="Filtrar por fecha">
                <button type="submit" class="p-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Filtrar</button>
                <?php if ($fecha_filtro): ?>
                    <a href="verPedido.php" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600">Eliminar Filtro</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if ($result->num_rows > 0): ?>
            <div class="overflow-x-auto max-w-4xl mx-auto">
                <table class="min-w-full bg-white table-auto border-collapse shadow-lg rounded-lg">
                    <thead>
                        <tr class="bg-yellow-500 text-white">
                            <th class="py-2 px-4 border-b text-left text-sm">Código de Pedido</th>
                            <th class="py-2 px-4 border-b text-left text-sm">Fecha</th>
                            <th class="py-2 px-4 border-b text-left text-sm">Estado</th>
                            <th class="py-2 px-4 border-b text-left text-sm">Total</th>
                            <th class="py-2 px-4 border-b text-left text-sm">Envió</th>
                            <th class="py-2 px-4 border-b text-left text-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pedido = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-100 transition duration-200">
                                <td class="py-2 px-4 border-b text-center text-sm"><?php echo $pedido['cod_ped']; ?></td>
                                <td class="py-2 px-4 border-b text-center text-sm"><?php echo date("d/m/Y", strtotime($pedido['Fec_ped'])); ?></td>

                                <!-- Aquí aplicamos el banner según el estado -->
                                <td class="py-2 px-4 border-b text-center text-sm">
                                    <?php
                                    $estado = $pedido['estado_pedido'];
                                    $estadoClase = '';
                                    $estadoTexto = '';

                                    switch ($estado) {
                                        case "Pendiente":
                                            $estadoClase = 'bg-yellow-300 text-yellow-700';
                                            $estadoTexto = 'PENDIENTE';
                                            break;
                                        case "Pagado":
                                            $estadoClase = 'bg-blue-300 text-blue-700';
                                            $estadoTexto = 'PAGADO';
                                            break;
                                        case "En_proceso":
                                            $estadoClase = 'bg-orange-300 text-orange-700';
                                            $estadoTexto = 'EN PROCESO';
                                            break;
                                        case "Entregado":
                                            $estadoClase = 'bg-green-300 text-green-700';
                                            $estadoTexto = 'ENTREGADO';
                                            break;
                                        case "Anulado":
                                            $estadoClase = 'bg-red-300 text-red-700';
                                            $estadoTexto = 'ANULADO';
                                            break;
                                        default:
                                            $estadoClase = 'bg-gray-300 text-gray-700';
                                            $estadoTexto = 'Estado Desconocido';
                                    }
                                    ?>
                                    <div class="p-2 rounded-md <?php echo $estadoClase; ?> font-semibold"><?php echo $estadoTexto; ?></div>
                                </td>

                                <td class="py-2 px-4 border-b text-center text-sm"><?php echo "S/ " . number_format($pedido['total'], 2); ?></td>
                                <td class="py-2 px-4 border-b text-center text-sm"><?php echo $pedido['tipo_envio']; ?></td>
                                <!--                                 <td class="py-2 px-4 border-b text-center text-sm">
                                    <a href="detalle_pedido.php?cod_ped=<?php echo $pedido['cod_ped']; ?>" class="text-blue-500 hover:underline">Ver Detalles</a>
                                </td> -->
                                <td class="py-2 px-4 border-b text-center text-sm">
                                    <a href="detalle_pedido.php?cod_ped=<?php echo $pedido['cod_ped']; ?>" class="text-blue-500 hover:underline">Ver Detalles</a>
                                    <br>
                                    <a href="generar_ticket.php?cod_ped=<?php echo $pedido['cod_ped']; ?>" class="text-green-500 hover:underline mt-2 block">Generar Ticket</a>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-700 text-center">No tienes pedidos registrados.</p>
        <?php endif; ?>

        <!-- Paginación -->
        <div class="flex justify-center mt-6">
            <ul class="flex space-x-4">
                <?php if ($pagina_actual > 1): ?>
                    <li><a href="?pagina=<?php echo $pagina_actual - 1; ?>&fecha=<?php echo htmlspecialchars($fecha_filtro); ?>" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">&laquo; Anterior</a></li>
                <?php endif; ?>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <li><a href="?pagina=<?php echo $pagina_actual + 1; ?>&fecha=<?php echo htmlspecialchars($fecha_filtro); ?>" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Siguiente &raquo;</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Banner informativo sobre los estados -->
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mt-6 mb-6">
            <strong>¿Cómo funcionan los estados de los pedidos?</strong>
            <ul class="list-inside list-disc mt-2">
                <li><strong>PENDIENTE:</strong> El pedido fue pagado pero aún no ha sido confirmado por nosotros.</li>
                <li><strong>PAGADO:</strong> El pedido fue validado y ya está cancelado.</li>
                <li><strong>EN PROCESO:</strong> El pedido está en etapa de preparación.</li>
                <li><strong>ENTREGADO:</strong> El pedido fue entregado correctamente.</li>
                <li><strong>ANULADO:</strong> El pedido fue anulado.</li>
            </ul>
        </div>


    </div>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>