<?php
session_start();
$numero_productos = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
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
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <style>
        nav.bg-white {
            background-color: #FFF7E8;
            /* Color de fondo */
            box-shadow: none;
            /* Elimina la sombra */
        }

        .slick-prev,
        .slick-next {
            background-color: rgba(125, 90, 59, 0.8);
            /* Color oscuro para botones de flecha */
            border-radius: 50%;
            color: #FFF7E8;
        }

        .slick-dots li button:before {
            color: #C88A64;
            /* Color de puntos de navegación */
        }

        .slick-dots li.slick-active button:before {
            color: #7D5A3B;
            /* Color del punto activo */
        }

        .product-carousel img {
            width: 100%;
            height: 200px;
            /* Ajustar según tu diseño */
            object-fit: cover;
            /* Para que las imágenes se recorten en lugar de estirarse */
            border-radius: 8px;
        }

        .product-carousel .slick-slide {
            margin: 0 10px;
            /* Ajustar el espacio entre los productos */
        }

        .product-carousel .slick-slide>div {
            background: #FFF7E8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .product-carousel .slick-slide>div:hover {
            transform: scale(1.05);
            /* Aumenta el tamaño en hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .header-text {
            font-size: 3rem;
            font-weight: bold;
            color: #3B2A1A;
            /* Un marrón oscuro más rico para resaltar */
            text-align: center;
        }

        .header-subtext {
            font-size: 1.5rem;
            color: #4E2F20;
            /* Un marrón mucho más oscuro para el subtexto */
            text-align: center;
        }
    </style>

    <title>Panadería "Los Gemelos"</title>

</head>

<body class="bg-gray-100">
    <!--Navigation-->
    <nav class="bg-white">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <a class="navbar-brand flex-shrink-0" href="index.php">
                        <img src="logo.png" width="30" height="90" class="d-inline-block align-top" alt="">
                    </a>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="index.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                            <a href="tienda.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Tienda</a>
                            <a href="historia.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Historia</a>
                            <a href="establecimiento.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Establecimientos</a>
                            <a href="contacto.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Contáctanos</a>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="flex items-center">
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <?php if (!(isset($_SESSION['cl']))) { ?>
                                <a href="nuevo_cliente.php" class="btn bg-green-500 hover:bg-green-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Registrarse</a>
                            <?php } ?>
                        </div>
                        <div class="form-inline my-2 my-lg-0">
                            <?php if (!(isset($_SESSION['cl']))) { ?>
                                <a href="login/" class="btn bg-blue-500 hover:bg-blue-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Iniciar sesión</a>
                            <?php } ?>
                            <?php if (isset($_SESSION['cl'])) { ?>
                                <a href="salir.php" class="btn bg-red-500 hover:bg-red-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Salir</a>
                            <?php } ?>
                        </div>
                        <a href="carritoindex.php" id="carrito-btn" class="ml-4 text-gray-900 hover:text-gray-600 relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-count" class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center"><?php echo $numero_productos; ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Inicio</a>
                <a href="historia.html" class="text-gray-900 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Historia</a>
                <a href="contacto.php" class="text-gray-900 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Contáctanos</a>
            </div>
        </div>
    </nav>

    <!--Header-->
    <div class="bg-yellow-400 py-12 bg-cover bg-center" style="background-image: url('/basededatos/fotos/portada.png');">
        <div class="container mx-auto text-center bg-opacity-75 p-4 rounded-lg">
            <h1 class="header-text">"Los Gemelos"</h1>
            <p class="header-subtext">Del horno a tu mesa, frescura y calidad en cada bocado.</p>

            <form id="filterForm" class="relative mt-6 max-w-screen-md mx-auto">
                <div class="relative flex items-center">
                    <span class="absolute left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" class="border-2 border-gray-300 bg-white h-10 pl-10 pr-10 rounded-lg text-sm focus:outline-none w-full" id="barra-busqueda" name="busqueda" placeholder="¿Qué se te antoja hoy?" value="<?php echo htmlspecialchars($busqueda); ?>">
                    <?php if ($busqueda != ''): ?>
                        <span class="absolute right-0 pr-3 flex items-center">
                            <button type="button" id="clearSearch" class="text-gray-400 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </span>
                    <?php endif; ?>
                </div>
                <button type="submit" class="hidden"></button>
            </form>
        </div>
    </div>

    <!-- Carrusel de Productos -->
    <div class="container mx-auto py-8 px-8">
        <div class="product-carousel">
            <?php
            // Conexión y consulta a la base de datos
            require("basededatos/connectionbd.php");
            $sabor = isset($_GET['sabor']) ? $_GET['sabor'] : '';
            $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

            $query = "SELECT stock, nombre, imagen, sabor, ID_CATPRODUCTO, descripcion, precio FROM catproducto WHERE 1=1";
            if ($busqueda != '') {
                $query .= " AND (nombre LIKE '%" . mysqli_real_escape_string($conn, $busqueda) . "%' OR descripcion LIKE '%" . mysqli_real_escape_string($conn, $busqueda) . "%')";
            }

            $result = mysqli_query($conn, $query);
            while ($fila = mysqli_fetch_array($result)) {
                $Nom = $fila['nombre'];
                $cod = $fila['precio'];
                $sab = $fila['sabor'];
                $des = $fila['descripcion'];
                $stock = $fila['stock'];
                $id = $fila['ID_CATPRODUCTO'];
                $img = $fila['imagen'];
                if ($stock > 0) {
            ?>
                    <div>
                        <div class="bg-white p-4 rounded-lg shadow-lg">
                            <img src="basededatos/<?php echo $img; ?>" alt="<?php echo $Nom; ?>" class="w-full h-48 object-cover rounded-lg mb-4">
                            <h2 class="text-xl font-bold text-gray-800"><?php echo $Nom; ?></h2>
                            <p class="text-gray-600"><?php echo $des; ?></p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-gray-800 font-bold">Precio: S/ <?php echo $cod; ?></span>
                                <?php if (isset($_SESSION['cl'])) { ?>
                                    <a href="#" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 add-to-cart" data-id="<?php echo $id; ?>">Añadir al carrito</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Frase del Día -->
    <div class="bg-yellow-400 py-8">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">FRASE DEL DÍA</h2>
            <p class="text-xl text-gray-700">No solo los ingredientes hacen que el pan sea rico, el amor con el que lo hacemos le da un toque especial.</p>
        </div>
    </div>

    <!-- Whatsapp -->
    <?php include 'whatsapp.php'; ?>

    <!--Footer-->
    <?php include 'footer.php'; ?>


    <!--JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.product-carousel').slick({
                slidesToShow: 4, // Número de productos visibles por vez
                slidesToScroll: 1, // Número de productos que se desplazan por vez
                autoplay: true, // Activa el desplazamiento automático
                autoplaySpeed: 3000, // Tiempo en milisegundos entre cada desplazamiento automático
                dots: true, // Muestra puntos de navegación
                arrows: true, // Muestra flechas de navegación
                pauseOnHover: true, // Pausa el autoplay cuando se pasa el ratón por encima
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</body>

</html>