<?php
session_start();
if ((isset($_SESSION['cl']))) { ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <title>Modificar Redes Sociales</title>

        <!-- Style -->
        <?php
        require('Style.php');
        ?>
    </head>

    <body id="page-top">
        <div id="wrapper">

            <!-- Sidebar -->
            <?php
            require('menu.php');
            ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php
                    require('Navigation.php');
                    ?>
                    <!-- End of -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Editar Redes Sociales</h1>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Redes</h6>
                            </div>
                            <div class="card-body">
                                <!-- Add Example -->
                                <?php
                                require("../basededatos/connectionbd.php");
                                $mic = $_GET['id'];
                                $query = "SELECT * FROM redes WHERE redes.id='$mic'";
                                $result = mysqli_query($conn, $query);
                                $i = 0;
                                while ($fila = mysqli_fetch_array($result)) {
                                    $id = $fila['id'];
                                    $Nom = $fila['red_social'];
                                    $url = $fila['url'];
                                    $i++; ?>
                                    <form action="../basededatos/actuaRedes.php" method="POST">
                                        <div class="form-row">
                                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            <div class="form-group col-md-2">
                                                <label for="inputName">Nombre</label>
                                                <input type="text" value="<?php echo $Nom; ?>" class="form-control" id="inputName" name="nom" placeholder="Nombre de red Social">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputName">Url</label>
                                                <input type="text" value="<?php echo $url; ?>" name="url" class="form-control" id="inputName" placeholder="URL">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <button type="button" class="btn btn-danger float-right" style="margin-right: 10px;" onclick="window.location.href='../backend/Redes_Ver.php';">Cancelar</button>
                                    <button type="submit" class="btn btn-primary float-right" style="margin-right: 10px;">Actualizar</button>
                                    </form>
                                    <!--End  Add Example -->
                            </div>
                        </div>
                    </div>

                    <!-- Validation -->
                    <?php
                    require('Validation.php');
                    ?>
                    <!-- End Validation -->

                    <!-- /.container-fluid -->
                    <script src="vendor/jquery/jquery.min.js"></script>
                    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                    <!-- Core plugin JavaScript-->
                    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

                    <!-- Custom scripts for all pages-->
                    <script src="js/sb-admin-2.min.js"></script>

                    <!-- Page level plugins -->
                    <script src="vendor/datatables/jquery.dataTables.js"></script>
                    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

                    <!-- Page level custom scripts -->
                    <script src="js/demo/datatables-demo.js"></script>
    </body>

    </html>
<?php }
require('llenar3.php');
?>