<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Freskypan - Panadería en Fusagasugá</title>

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/629388bad9.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root {
      --primary-light: #d4a373;
      --primary-dark: #c59462;
      --secondary-light: #4A90E2;
      --secondary-dark: #357ABD;
    }

    .bg-custom {
      background-image: url('./backend/img/2024/vision.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .btn-primary {
      background-color: var(--primary-light);
      color: white;
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
    }

    .btn-secondary {
      background-color: var(--secondary-light);
      color: white;
    }

    .btn-secondary:hover {
      background-color: var(--secondary-dark);
    }
  </style>
</head>

<body class="bg-gray-100">

  <?php
  if (isset($_GET['status']) && isset($_GET['message'])) {
    $status = $_GET['status'];
    $message = urldecode($_GET['message']);  // Decodificar el mensaje
    echo "<script>
                Swal.fire({
                    icon: '$status',
                    title: '$status' === 'success' ? '¡Éxito!' : 'Error',
                    text: '$message'
                }).then(() => {
                    if ('$status' === 'success') {
                        // Redirigir después de 2 segundos si es exitoso
                        setTimeout(() => {
                            window.location.href = './login/'; // Redirigir al login
                        }, 800);
                    }
                });
              </script>";
  }
  ?>

  <!-- Página principal -->
  <main class="min-h-screen bg-custom flex justify-center items-center p-4">
    <section class="bg-gray-50 dark:bg-gray-900 w-full max-w-md p-6 rounded-lg shadow-md dark:bg-gray-800">
      <!-- Logo -->
      <div class="flex justify-center mb-6">
        <img class="w-12 h-12" src="logo.png" alt="Logo Los gemelos">
      </div>

      <!-- Título -->
      <h2 class="text-xl font-bold leading-tight text-gray-900 md:text-2xl dark:text-white text-center">
        Restablecer contraseña <span class="text-sm font-normal">(Clientes)</span>
      </h2>

      <!-- Formulario -->
      <form class="space-y-4 mt-4" action="basededatos/actuac_pass.php" method="POST">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white">DNI</label>
          <input type="text" name="dni" id="dni" placeholder="" required
            class="w-full bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white">Nueva contraseña</label>
          <input type="password" name="password" id="password" placeholder="••••••••" required
            class="w-full bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
          <label for="confirm-password" class="block text-sm font-medium text-gray-900 dark:text-white">Confirmar
            contraseña</label>
          <input type="password" name="confirm-password" id="confirm-password" placeholder="••••••••" required
            class="w-full bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div class="flex items-start">
          <input id="terms" type="checkbox" required
            class="w-4 h-4 rounded border border-gray-300 bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600">
          <label for="terms" class="ml-2 text-sm text-gray-500 dark:text-gray-300">Acepto los <a href="#"
              class="text-primary-600 hover:underline dark:text-primary-500">Términos y condiciones</a></label>
        </div>

        <button type="submit"
          class="w-full btn-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-primary-dark focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-800">
          Restablecer contraseña
        </button>
        <a href="../index.php"
          class="w-full inline-block text-center btn-secondary font-medium rounded-lg text-sm px-5 py-2.5 mt-4 hover:bg-secondary-dark focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-800">
          Continuar como invitado
        </a>
      </form>
    </section>
  </main>
</body>

</html>