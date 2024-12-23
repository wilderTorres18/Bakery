<?php
session_start();
$numero_productos = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
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
    <style>
        .banner-section {
            position: relative;
            background-image: url('img/banner.png');
            /* Reemplaza con la ruta de tu imagen */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 2rem 0;
            text-align: center;
            color: white;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Ajusta la transparencia aquí */
        }

        .banner-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!--Navigation-->
    <?php include 'navigation.php'; ?>
    <!-- Quiénes Somos -->
    <section class="py-2 bg-gray-100">
        <div class="banner-section">
            <div class="banner-overlay"></div>
            <div class="banner-content">
                <div class="text-center">
                    <h2 class="text-4xl font-bold text-white">Nuestra Historia</h2>
                    <p class="mt-4 text-white">Conoce mas sobre nosotros</p>
                </div>
            </div>
        </div>
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="order-2 lg:order-1">
                    <div class="p-5">
                        <h2 class="text-3xl font-bold text-gray-800">¿Quiénes somos?</h2>
                        <p class="mt-4 text-gray-600">Somos "Los Gemelos", una empresa que nació en 2021 en la provincia de Sullana con el objetivo de satisfacer las necesidades de nuestros clientes con productos de alta calidad. Contamos con dos tiendas físicas ubicadas en la calle Benal y en la calle Víctor Raúl. Para expandir nuestra presencia y llegar a más clientes, hemos creado una página web. Nuestros clientes confían en nosotros por la variedad y calidad de nuestros panes.</p>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="p-5">
                        <img class="w-full h-auto rounded-lg shadow-lg" src="img/somos.jpg" alt="¿Quiénes somos?">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Misión -->
    <section class="py-2 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <div class="p-5">
                        <img class="w-full h-auto rounded-lg shadow-lg" src="img/mision.jpg" alt="Misión">
                    </div>
                </div>
                <div>
                    <div class="p-5">
                        <h2 class="text-3xl font-bold text-gray-800">Misión</h2>
                        <p class="mt-4 text-gray-600">Nuestra misión es hornear productos de la mejor calidad y frescura todos los días. Nos esforzamos por ofrecer una amplia variedad de panes que destacan por sus ingredientes de primera calidad. Además, facilitamos la entrega a domicilio para asegurar un servicio excelente y satisfacer a nuestra clientela.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visión -->
    <section class="py-2 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="order-2 lg:order-1">
                    <div class="p-5">
                        <h2 class="text-3xl font-bold text-gray-800">Visión</h2>
                        <p class="mt-4 text-gray-600">Nuestra visión es ser líderes en la industria panificadora, reconocidos por la excelencia de nuestros productos y el servicio excepcional que brindamos a nuestros clientes.</p>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="p-5">
                        <img class="w-full h-auto rounded-lg shadow-lg" src="img/vision.jpg" alt="Visión">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!--JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
</body>

</html>