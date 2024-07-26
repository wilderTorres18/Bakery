
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
  <link href="/css/tailwind.css" rel="stylesheet">
  <link rel="stylesheet" href="login/vendor/bootstrap/css/bootstrap.min.css" crossorigin="anonymous">
  <!--FontAwesome-->
  <script src="js/629388bad9.js"></script>
  <!--Fonts-->
  <link href="css/font.css" rel="stylesheet">
  <title>Freskypan - Panaderia en Fusagasuga</title>
</head>

<body>
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
                            <a href="index.php"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                            <a href="historia.php"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Historia</a>
                            <a href="establecimiento.php"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Establecimientos</a>
                                <a href="contacto.php"
                                class="text-gray-900 bg-yellow-500 hover:bg-yellow-600 px-3 py-2 rounded-md text-sm font-medium">Contáctanos</a>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="flex items-center">
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <?php if (!(isset($_SESSION['cl']))) { ?>
                            <a href="nuevo_cliente.php"
                                class="btn bg-green-500 hover:bg-green-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Registrarse</a>
                            <?php } ?>
                        </div>
                        <div class="form-inline my-2 my-lg-0">
                            <?php if (!(isset($_SESSION['cl']))) { ?>
                            <a href="login/"
                                class="btn bg-blue-500 hover:bg-blue-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Iniciar
                                sesión</a>
                            <?php } ?>
                            <?php if (isset($_SESSION['cl'])) { ?>
                            <a href="salir.php"
                                class="btn bg-red-500 hover:bg-red-600 text-white my-2 my-sm-0 px-3 py-2 rounded-md text-sm font-medium">Salir</a>
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

  <!--Header-->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">COntactanos</h1>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Clientes</h6>
      </div>
      <div class="card-body">
        <!-- Add Example -->
        <form action="basededatos/agregarc2.php" method="POST">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputName">Numero de Cedula</label>
              <input type="number" class="form-control" id="inputName" name="ced" placeholder="">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPrice">Telefono</label>
              <input type="number" name="tel" class="form-control" id="inputrice" placeholder="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputCantidad">Nombre</label>
              <input type="text" name="nom" class="form-control" id="inputCantidad" placeholder="">
            </div>
            <div class="form-group col-md-3">

              <label for="inputCantidad">Primer Apellido</label>
              <input type="text" name="a1" class="form-control" id="inputCantidad" placeholder="">
            </div>
            <div class="form-group col-md-3">

              <label for="inputCantidad">Segundo Apellido</label>
              <input type="text" name="a2" class="form-control" id="inputCantidad" placeholder="">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputName">Dirección</label>
              <input type="text" name="dir" class="form-control" id="inputName" placeholder="">
              <div class="space-small"></div>
              <label for="exampleFormControlTextarea1">Mensaje</label>
              <textarea name="des" class="form-control" id="exampleFormControlTextarea1" rows="7"></textarea>
            </div>
            <img src="img/Captura.PNG">
            <!-- <div class="form-group col-md-6 text-center" >
                  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15913.82878315453!2d-74.37047654999999!3d4.324887749999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sco!4v1570575086503!5m2!1ses!2sco" width="400" height="300" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                </div> -->


          </div>




          <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <!--End  Add Example -->
      </div>
    </div>

  </div>

  <!--Footer-->
  <footer class="contenedor">
    <div class="redes-sociales">
      <div class="contenedor-icono">
        <a href="#" target="_blank" class="twitter">
          <i class="fab fa-twitter"></i>
        </a>
      </div>
      <div class="contenedor-icono">
        <a href="#" target="_blank" class="facebook">
          <i class="fab fa-facebook"></i>
        </a>
      </div>
      <div class="contenedor-icono">
        <a href="#" target="_blank" class="instagram">
          <i class="fab fa-instagram"></i>
        </a>
      </div>
    </div>
    <div class="creado-por">

    </div>
  </footer>

  <!--JavaScript-->
  <!--Muuri-->
  <script src="js/web-animations.min.js"></script>
  <script src="js/muuri.min.js"></script>
  <!--JQuery-->
  <script src="js/jquery-3.3.1.slim.min.js" crossorigin="anonymous">
  </script>
  <script src="js/popper.min.js" crossorigin="anonymous">
  </script>
  <script src="js/bootstrap.min.js" crossorigin="anonymous">
  </script>

  <script src="js/main.js"></script>
</body>

</html>