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
    <title>Freskypan - Panadería en Fusagasugá</title>
</head>
<style>
        .bg-custom {
            background-image: url('./backend/img/dos.jpg'); /* Reemplaza con la ruta a tu imagen */
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

<body class="bg-gray-100">
    <!-- component -->
    <!-- Create by joker banny -->
    <div class="h-screen bg-custom flex justify-center items-center">
        <div class="lg:w-2/5 md:w-1/2 w-2/3">
            <form class="bg-white p-10 rounded-lg shadow-lg min-w-full">
                <h1 class="text-center text-2xl mb-6 text-gray-600 font-bold font-sans">Registrate</h1>
                <div>
                    <label class="text-gray-800 font-semibold block my-3 text-md" for="username">Username</label>
                    <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="username" id="username" placeholder="username" />
                </div>
                <div>
                    <label class="text-gray-800 font-semibold block my-3 text-md" for="email">Email</label>
                    <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="email" id="email" placeholder="@email" />
                </div>
                <div>
                    <label class="text-gray-800 font-semibold block my-3 text-md" for="password">Password</label>
                    <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="password" id="password" placeholder="password" />
                </div>
                <div>
                    <label class="text-gray-800 font-semibold block my-3 text-md" for="confirm">Confirm password</label>
                    <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="confirm" id="confirm" placeholder="confirm password" />
                </div>
                <button type="submit" class="w-full mt-6 btn-register rounded-lg px-4 py-2 text-lg tracking-wide font-semibold font-sans">Register</button>
                <a href="../index.php" class="w-full mt-6 mb-3 btn-guest rounded-lg px-4 py-2 text-lg text-center tracking-wide font-semibold font-sans block">Continuar como invitado</a>
            </form>
        </div>
    </div>
</body>
</html>
