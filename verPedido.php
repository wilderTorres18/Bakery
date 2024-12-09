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

// Consulta para obtener los pedidos del cliente con el filtro de fecha
$query = "SELECT 
            cod_ped, 
            MAX(Fec_ped) AS Fec_ped, 
            MAX(est_ped) AS estado_pedido, 
            SUM(total) AS total,
            MAX(tipo_envio) AS tipo_envio  -- Agregamos el campo tipo_envio
          FROM pedidos 
          WHERE dni_cl = ? 
          " . ($fecha_filtro ? "AND Fec_ped LIKE ?" : "") . "
          GROUP BY cod_ped";


$stmt = $conn->prepare($query);
if ($fecha_filtro) {
    $fecha_filtro = "%" . $fecha_filtro . "%";  // Preparar filtro para fecha
    $stmt->bind_param("ss", $dni_cl, $fecha_filtro);
} else {
    $stmt->bind_param("s", $dni_cl);
}
$stmt->execute();
$result = $stmt->get_result();
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
            <strong>Nota:</strong> El pago de tu pedido será validado a través de WhatsApp. Una vez confirmado, procederemos a preparar tu pedido y actualizar su estado. ¡Gracias por tu compra!
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

                                <!-- Aquí aplicamos la clase correspondiente al estado -->
                                <td class="py-2 px-4 border-b text-center text-sm">
                                    <?php
                                    switch ($pedido['estado_pedido']) {
                                        case "Pendiente":
                                            echo '<span class="text-yellow-600 font-semibold">PENDIENTE</span>';
                                            break;
                                        case "Pagado":
                                            echo '<span class="text-blue-600 font-semibold">PAGADO</span>';
                                            break;
                                        case "En Proceso":
                                            echo '<span class="text-orange-600 font-semibold">EN PROCESO</span>';
                                            break;
                                        case "Entregado":
                                            echo '<span class="text-green-600 font-semibold">ENTREGADO</span>';
                                            break;
                                        case "Anulado":
                                            echo '<span class="text-red-600 font-semibold">ANULADO</span>';
                                            break;
                                        default:
                                            echo '<span class="text-gray-500 font-semibold">Estado Desconocido</span>';
                                    }
                                    ?>
                                </td>

                                <td class="py-2 px-4 border-b text-center text-sm"><?php echo "S/ " . number_format($pedido['total'], 2); ?></td>
                                <td class="py-2 px-4 border-b text-center text-sm"><?php echo $pedido['tipo_envio']; ?></td>
                                <td class="py-2 px-4 border-b text-center text-sm">
                                    <a href="detalle_pedido.php?cod_ped=<?php echo $pedido['cod_ped']; ?>" class="text-blue-500 hover:underline">Ver Detalles</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-700 text-center">No tienes pedidos registrados.</p>
        <?php endif; ?>
    </div>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>