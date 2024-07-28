<?php
session_start();
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
  <title>Freskypan - Panaderia en Fusagasuga</title>
</head>

<body class="bg-gray-100">
  <!--Navigation-->
  <nav class="bg-white shadow-md">
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
          <a class="navbar-brand flex-shrink-0" href="#">
            <img src="favicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
          </a>
          <div class="hidden sm:block sm:ml-6">
            <div class="flex space-x-4">
              <a href="index.php" class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
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
            <a href="carrito.php" class="ml-4 text-gray-900 hover:text-gray-600">
              <i class="fas fa-shopping-cart"></i>
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

  <!-- Contact Us Section -->
  <div class="container mx-auto px-6 py-16">
    <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">Contáctanos</h2>
    <div class="flex flex-wrap -mx-6">
      <div class="w-full lg:w-1/2 px-6 mb-12 lg:mb-0">
        <div class="bg-white p-8 rounded-lg shadow-lg">
          <h3 class="text-2xl font-bold text-gray-800 mb-6">Envíanos un mensaje</h3>
          <form action="basededatos/agregarc2.php" method="POST">
            <div class="mb-4">
              <label for="ced" class="block text-gray-600 font-bold mb-2">Número de Cedula</label>
              <input type="number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="ced" name="ced" placeholder="">
            </div>
            <div class="mb-4">
              <label for="tel" class="block text-gray-600 font-bold mb-2">Teléfono</label>
              <input type="number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="tel" name="tel" placeholder="">
            </div>
            <div class="mb-4">
              <label for="nom" class="block text-gray-600 font-bold mb-2">Nombre</label>
              <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="nom" name="nom" placeholder="">
            </div>
            <div class="mb-4">
              <label for="a1" class="block text-gray-600 font-bold mb-2">Primer Apellido</label>
              <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="a1" name="a1" placeholder="">
            </div>
            <div class="mb-4">
              <label for="a2" class="block text-gray-600 font-bold mb-2">Segundo Apellido</label>
              <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="a2" name="a2" placeholder="">
            </div>
            <div class="mb-4">
              <label for="dir" class="block text-gray-600 font-bold mb-2">Dirección</label>
              <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="dir" name="dir" placeholder="">
            </div>
            <div class="mb-4">
              <label for="des" class="block text-gray-600 font-bold mb-2">Mensaje</label>
              <textarea class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-yellow-500" id="des" name="des" rows="7" placeholder=""></textarea>
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
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15913.82878315453!2d-74.37047654999999!3d4.324887749999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sco!4v1570575086503!5m2!1ses!2sco" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
      </div>
    </div>
  </div>

  <!--Footer-->
  <footer class="bg-gray-800 py-6 mt-12">
    <div class="container mx-auto text-center text-white">
      <div class="flex justify-center space-x-6 mb-4">
        <a href="#" class="text-white hover:text-gray-400">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="text-white hover:text-gray-400">
          <i class="fab fa-facebook"></i>
        </a>
        <a href="#" class="text-white hover:text-gray-400">
          <i class="fab fa-instagram"></i>
        </a>
      </div>
      <p>Sitio diseñado por <a href="#" class="underline">2024</a> - <a href="#" class="underline">softwar </a></p>
    </div>
  </footer>

  <!--JavaScript-->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNddZrEvvOCcfjOgiWtLNwSEbCrsczx3phrrYsDAyzpCfwfjJrEMyuwYvJtbt3I" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js" integrity="sha384-pP5pYqQn9l3Bbo1Mj4Ad5Nq1dhevhSiwAHuQPs6abQh4Jt5e1Lx6U5G78ycBocsr" crossorigin="anonymous"></script>
</body>

</html>
