<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/629388bad9.js"></script>
    <title>Registrate</title>
    <style>
        .bg-custom {
            background-image: url('./backend/img/2024/vision.jpg'); /* Reemplaza con la ruta a tu imagen */
            background-size: cover; /* Ajusta el tamaño de la imagen para cubrir todo el contenedor */
            background-position: center; /* Centra la imagen */
            background-repeat: no-repeat; /* No repite la imagen */
        }
        .btn-register {
            background-color: #d4a373; /* Marrón claro */
            color: white;
        }
        .btn-register:hover {
            background-color: #c59462; /* Marrón oscuro al pasar el ratón */
        }
        .btn-guest {
            background-color: #4A90E2; /* Azul claro */
            color: white;
        }
        .btn-guest:hover {
            background-color: #357ABD; /* Azul más oscuro al pasar el ratón */
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- component -->
    <div class="min-h-screen bg-custom flex justify-center items-center p-4">
        <div class="lg:w-2/5 md:w-1/2 w-full max-w-md">
            <form class="bg-white p-6 md:p-8 rounded-lg shadow-lg" action="basededatos/agregarc2.php" method="POST">
                <h1 class="text-center text-2xl mb-6 text-gray-600 font-bold font-sans">Regístrate</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-800 font-semibold block my-3 text-md" for="dni">DNI</label>
                        <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="number" name="dni" id="dni" placeholder="DNI" required/>
                    </div>
                    <div>
                        <label class="text-gray-800 font-semibold block my-3 text-md" for="tel">Teléfono</label>
                        <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="number" name="telefono" id="tel" placeholder="999999999" required/>
                    </div>
                    <div>
                        <label class="text-gray-800 font-semibold block my-3 text-md" for="nom">Nombre</label>
                        <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="nombre" id="nom" placeholder="Nombre" required/>
                    </div>
                    <div>
                        <label class="text-gray-800 font-semibold block my-3 text-md" for="a1">Primer apellido</label>
                        <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="apellido_1" id="a1" placeholder="Primer apellido" required/>
                    </div>
                    <div>
                        <label class="text-gray-800 font-semibold block my-3 text-md" for="a2">Segundo apellido</label>
                        <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="apellido_2" id="a2" placeholder="Segundo apellido" required/>
                    </div>
                    <div>
                        <label class="text-gray-800 font-semibold block my-3 text-md" for="dir">Dirección</label>
                        <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="direccion" id="dir" placeholder="Dirección" required/>
                    </div>
                    <div>
                        <label class="text-gray-800 font-semibold block my-3 text-md" for="des">Referencia de Dirección</label>
                        <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="descripcion" id="des" placeholder="Referencia " required/>
                    </div>
                    <div>
                        <label class="text-gray-800 font-semibold block my-3 text-md" for="pass">Password</label>
                        <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="password" name="pass" id="pass" placeholder="......" required/>
                    </div>
                </div>
                <button type="submit" class="w-full mt-6 btn-register rounded-lg px-4 py-2 text-lg tracking-wide font-semibold font-sans">Registrar</button>
                <a href="../index.php" class="w-full mt-6 mb-3 btn-guest rounded-lg px-4 py-2 text-lg text-center tracking-wide font-semibold font-sans block">Continuar como invitado</a>
            </form>
        </div>
    </div>
</body>
</html>
