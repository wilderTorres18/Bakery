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
  <!-- CSS-->
  <link rel="stylesheet" href="css/styles.css">
  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!--FontAwesome-->
  <script src="https://kit.fontawesome.com/629388bad9.js" crossorigin="anonymous"></script>
  <!--Fonts-->
  <link href="css/font.css" rel="stylesheet">
  <!-- Custom favicon for this template-->
  <link rel="icon" type="image/png" href="logo.png" />
  <title>Los Gemelos</title>

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

  <div class="banner-section">
    <div class="banner-overlay"></div>
    <div class="banner-content">
      <div class="text-center">
        <h2 class="text-4xl font-bold text-white">Contáctanos</h2>
        <p class="mt-4 text-white">Ingresa tus datos y nosotros te llamamos</p>
      </div>
    </div>
  </div>

  <!-- Contact Us Section -->
  <div class="container mx-auto px-6 py-16">
    <div class="flex flex-wrap -mx-6">
      <div class="w-full lg:w-1/2 px-6 mb-12 lg:mb-0">
        <div class="bg-white p-8 rounded-lg shadow-lg">
          <h3 class="text-2xl font-bold text-gray-800 mb-6">Envíanos un mensaje</h3>
          <form action="basededatos/agregarMensaje.php" method="POST">
            <div class="mb-4">
              <label for="tel" class="block text-gray-600 font-bold mb-2">Teléfono</label>
              <input type="tel" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="tel" name="tel" placeholder="" maxlength="9" minlength="9" pattern="\d{9}" required oninput="validateTel(this)" required>
              <span id="telError" class="text-red-500 text-sm hidden">Debe ser un número de 9 dígitos.</span>
            </div>

            <div class="mb-4">
              <label for="nom" class="block text-gray-600 font-bold mb-2">Nombres</label>
              <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="nom" name="nom" placeholder="" required>
            </div>
            <div class="mb-4">
              <label for="dir" class="block text-gray-600 font-bold mb-2">Dirección</label>
              <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="dir" name="dir" placeholder="" required>
            </div>
            <div class="mb-4">
              <label for="des" class="block text-gray-600 font-bold mb-2">Mensaje</label>
              <textarea class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="des" name="des" rows="4" placeholder="" required></textarea>
            </div>
            <div class="text-right">
              <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Enviar</button>
            </div>
          </form>
        </div>
      </div>
      <div class="w-full lg:w-1/2 px-6">
        <div class="bg-white p-8 rounded-lg shadow-lg">
          <h3 class="text-2xl font-bold text-gray-800 mb-6">Nuestra Ubicación</h3>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.284067843343!2d-80.7588793!3d-5.5713565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x902b9bfa58f50ffb%3A0x3ec408e19f74ae0e!2sSullana%2C%20Per%C3%BA!5e0!3m2!1ses!2sus!4v1628082079984!5m2!1ses!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>

  <!-- Carrito Modal -->
  <div id="carritoModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75  hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Carrito de Compras</h2>
                <button id="closeCarritoModal">&times;</button>
            </div>
            <div id="carritoContent">
                <!-- Contenido del carrito aquí -->
            </div>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      const urlParams = new URLSearchParams(window.location.search);
      const status = urlParams.get('status');

      if (status === 'success') {
        Swal.fire({
          title: 'Mensaje enviado',
          text: 'Tu mensaje ha sido enviado exitosamente.',
          icon: 'success',
          confirmButtonText: 'OK'
        });
      } else if (status === 'error') {
        Swal.fire({
          title: 'Error',
          text: 'Hubo un problema al enviar tu mensaje. Por favor, intenta de nuevo.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    });

    function validateTel(input) {
      const telError = document.getElementById('telError');
      if (input.value.length === 9 && /^\d{9}$/.test(input.value)) {
        telError.classList.add('hidden');
        input.classList.remove('border-red-500');
        input.classList.add('border-yellow-500');
      } else {
        telError.classList.remove('hidden');
        input.classList.remove('border-yellow-500');
        input.classList.add('border-red-500');
      }
    }
  </script>
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
        $('.add-to-cart').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: './carrito/CarModal.php',
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#carritoContent').html(response);
                    $('#carritoModal').removeClass('hidden');
                    updateCartCount();
                }
            });
        });

        $('#carrito-btn').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: './carrito/CarModal.php',
                method: 'GET',
                success: function(response) {
                    $('#carritoContent').html(response);
                    $('#carritoModal').removeClass('hidden');
                }
            });
        });

        $('#closeCarritoModal').click(function() {
            $('#carritoModal').addClass('hidden');
        });

        function updateCartCount() {
            $.ajax({
                url: './carrito/CarModal.php',
                method: 'POST',
                data: {
                    action: 'count'
                },
                success: function(response) {
                    $('#cart-count').text(response);
                }
            });
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }
    </script>

</body>

</html>