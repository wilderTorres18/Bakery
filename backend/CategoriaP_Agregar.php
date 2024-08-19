<?php
session_start();
if ((isset($_SESSION['cl']))) {
    require("../basededatos/connectionbd.php");
    $codg = "Select MAX(ID_TIPOPRODUCTO) as idc from TIPOPRODUCTO";
    $res = mysqli_query($conn, $codg);
    $file = mysqli_fetch_array($res);
    if ((mysqli_num_fields($res)) > 0) {
        $codg2 = intval($file['idc']) + 1;
    } else if ((mysqli_num_fields($res)) == 0) {
        $codg2 = 1;
    }
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <title>Agregar Catgoria de Producto</title>
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
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Agregar Categoria de Producto</h1>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Categoria</h6>
                            </div>

                            <div class="card-body">
                                <form action="../basededatos/agregacate.php" method="POST">
                                    <div class="form-row">
                                        <div class="form-group col-md-1">
                                            <label for="inputCode">Código</label>
                                            <input type="number" name="cd" class="form-control" maxlength="11" oninput="maxlengthNumber(this)" onkeypress="return cod_tip(event)" onpaste="return false" id="inputCode" placeholder="" readonly="" value="<?php echo $codg2; ?>">
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="inputName">Nombre</label>
                                            <input type="text" name="nom" class="form-control" maxlength="30" onkeypress="return Nom_tip(event)" onpaste="return false" id="inputName" placeholder="">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <!-- Trigger the modal with a button -->
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Añadir</button>
                                        <button type="button" class="btn btn-danger float-right" style="margin-right: 10px;" onclick="window.location.href='../backend/CategoriaP_Ver.php';">Cancelar</button>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">¡Alerta!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de agregar este ítem?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--End Add Example -->
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                    <script>
                        function maxlengthNumber(ob) {
                            console.log(ob.value);
                            if (ob.value.length > ob.maxLength) {
                                ob.value = ob.value.slice(0, ob.maxLength);
                            }
                        }
                    </script>
                    <!-- Validation -->
                    <?php
                    require('Validation.php');
                    ?>
                    <!-- End Validation -->

                    <script src="vendor/jquery/jquery.min.js"></script>
                    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                    <script>
                        function cambia(text) {
                            document.getElementById('prueba').value = text;
                        }
                    </script>

                    <!-- Core plugin JavaScript-->
                    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
                    <!-- Custom scripts for all pages-->
                    <script src="js/sb-admin-2.min.js"></script>
                    <!-- Page level plugins -->
                    <script src="vendor/datatables/jquery.dataTables.js"></script>
                    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
                    <!-- Page level custom scripts -->
                    <script src="js/demo/datatables-demo.js"></script>
                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
    </body>

    </html>
<?php }
require('llenar3.php');
?>