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

// Verificar que 'cod_ped' esté presente en la URL
if (isset($_GET['cod_ped'])) {
    $cod_ped = $_GET['cod_ped'];

    $query = "
    SELECT p.*, c.nombre
    FROM pedidos p
    INNER JOIN catproducto c ON p.cod_pro = c.ID_CATPRODUCTO  -- Relación con el campo correcto
    WHERE p.dni_cl = ? AND p.cod_ped = ?";


    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $dni_cl, $cod_ped);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Si no hay un 'cod_ped' en la URL, redirigir al usuario
    header("Location: verPedido.php");
    exit();
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

    <title>Detalles del Pedido - Panadería "Los Gemelos"</title>
</head>

<body class="bg-gray-100">

    <!-- Navigation -->
    <?php include 'navigation.php'; ?>

    <div class="container mx-auto my-10 p-5 bg-white shadow-xl rounded-xl">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Detalles del Pedido</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="min-w-full bg-white table-auto border-collapse shadow-md rounded-lg overflow-hidden">
                <thead class="bg-yellow-500 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left font-semibold text-sm">Fecha</th>
                        <th class="py-3 px-4 text-left font-semibold text-sm">Hora</th>
                        <th class="py-3 px-4 text-left font-semibold text-sm">Producto</th>
                        <th class="py-3 px-4 text-left font-semibold text-sm">Cantidad</th>
                        <th class="py-3 px-4 text-left font-semibold text-sm">Precio Unitario</th>
                        <th class="py-3 px-4 text-left font-semibold text-sm">Total</th>
                        <th class="py-3 px-4 text-left font-semibold text-sm">Dirección</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($pedido = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 border-b text-center"><?php echo date("d/m/Y", strtotime($pedido['Fec_ped'])); ?></td>
                            <td class="py-3 px-4 border-b text-center"><?php echo $pedido['hora_ped']; ?></td>
                            <td class="py-3 px-4 border-b text-center"><?php echo $pedido['nombre']; ?></td>
                            <td class="py-3 px-4 border-b text-center"><?php echo $pedido['can_ped']; ?></td>
                            <td class="py-3 px-4 border-b text-center"><?php echo "S/ " . number_format($pedido['precio_unit'], 2); ?></td>
                            <td class="py-3 px-4 border-b text-center"><?php echo "S/ " . number_format($pedido['total'], 2); ?></td>
                            <td class="py-3 px-4 border-b text-center"><?php echo $pedido['dir_ped']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-700 text-center mt-6">No se encontraron detalles para este pedido.</p>
        <?php endif; ?>

        <div class="flex justify-center mt-4">
            <a href="verPedido.php" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">Volver a Mis Pedidos</a>
        </div>
    </div>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>