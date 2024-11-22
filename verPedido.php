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

$query = "SELECT * FROM pedidos WHERE dni_cl = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $dni_cl);
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

    <!-- Custom favicon for this template-->
    <link rel="icon" type="image/png" href="logo.png" />

    <title>Panadería "Los Gemelos"</title>

</head>

<body class="bg-gray-100">

    <!--Navigation-->
    <?php include 'navigation.php'; ?>
    <div class="container mx-auto my-10 p-5 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Mis Pedidos</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="min-w-full bg-white border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID Pedido</th>
                        <th class="py-2 px-4 border-b">Fecha</th>
                        <th class="py-2 px-4 border-b">Estado</th>
                        <th class="py-2 px-4 border-b">Total</th>
                        <!-- -<th class="py-2 px-4 border-b">Acciones</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pedido = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4 border-b text-center"><?php echo $pedido['id_ped']; ?></td>
                            <td class="py-2 px-4 border-b text-center"><?php echo $pedido['Fec_ped']; ?></td>
                            <td class="py-2 px-4 border-b text-center"><?php echo $pedido['est_ped']; ?></td>
                            <td class="py-2 px-4 border-b text-center"><?php echo "S/ " . number_format($pedido['can_ped'], 2); ?></td>
                            <!--                             <td class="py-2 px-4 border-b text-center">
                                <a href="detalle_pedido.php?id=<?php echo $pedido['id_pedido']; ?>" class="text-blue-500 hover:underline">Ver Detalles</a>
                            </td> -->
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-700">No tienes pedidos registrados.</p>
        <?php endif; ?>

    </div>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!--JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
</body>

</html>