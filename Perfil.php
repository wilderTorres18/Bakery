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

    <!-- Navigation -->
    <?php include 'navigation.php'; ?>

    <div class="flex justify-center items-center min-h-screen pt-10">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-3xl">
            <h1 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Mi Perfil</h1>

            <!-- Formulario de perfil con tarjetas -->
            <form id="updateProfileForm" method="POST" action="basededatos/actuaprofileC.php" class="space-y-6">

                <!-- Tarjeta de Información Personal -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Información Personal</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="nomcl" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="nomcl" name="nomcl" value="<?php echo $_SESSION['cl']['nomcl']; ?>"
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <!-- Apellido Paterno -->
                        <div>
                            <label for="ape1" class="block text-sm font-medium text-gray-700">Apellido Paterno</label>
                            <input type="text" id="ape1" name="ape1" value="<?php echo $_SESSION['cl']['ape1']; ?>"
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <!-- Apellido Materno -->
                        <div>
                            <label for="ape2" class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                            <input type="text" id="ape2" name="ape2" value="<?php echo $_SESSION['cl']['ape2']; ?>"
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <!-- DNI -->
                        <div>
                            <label for="dnicl" class="block text-sm font-medium text-gray-700">DNI</label>
                            <input type="text" id="dnicl" name="dnicl" value="<?php echo $_SESSION['cl']['dnicl']; ?>"
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500" readonly>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Dirección -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Dirección</h2>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="dircl" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input type="text" id="dircl" name="dircl" value="<?php echo $_SESSION['cl']['dircl']; ?>"
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Descripción -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Descripción</h2>
                    <div class="grid grid-cols-1 gap-6">
                        <textarea id="descl" name="descl" rows="4"
                            class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-yellow-500 focus:border-yellow-500"><?php echo $_SESSION['cl']['descl']; ?></textarea>
                    </div>
                </div>

                <!-- Botón de Actualizar -->
                <div class="text-center">
                    <button type="submit"
                        class="bg-yellow-500 text-white px-6 py-3 rounded-md shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            if (<?php echo isset($_SESSION['status']) ? json_encode($_SESSION['status']) : 'null'; ?> === 'success') {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Tus datos han sido actualizados correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                <?php unset($_SESSION['status']); ?> // Limpiar el estado después de mostrarlo
            } else if (<?php echo isset($_SESSION['status']) ? json_encode($_SESSION['status']) : 'null'; ?> === 'error') {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al actualizar tus datos. Por favor, inténtalo de nuevo.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                <?php unset($_SESSION['status']); ?> // Limpiar el estado después de mostrarlo
            }
        });
    </script>

</body>

</html>