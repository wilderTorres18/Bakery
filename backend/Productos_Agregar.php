<?php
session_start();
if ((isset($_SESSION['cl']))) {
  require("../basededatos/connectionbd.php");
  $codg = "Select MAX(ID_CATPRODUCTO) as idc from CATPRODUCTO";
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
    <title>Agregar Productos</title>

    <?php
    require('Style.php');
    ?>

  </head>

  <body>
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
            <h1 class="h3 mb-2 text-gray-800">Agregar Productos</h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Productos</h6>
              </div>
              <div class="card-body">
                <!-- Aca se envian los datos a un archivo php ene el action="../basededatos/agregapd.php" -->
                <form action="../basededatos/agregapd.php" method="POST" enctype="multipart/form-data">

                  <label for="inputName" style="display: none">Código del Producto</label>
                  <input type="number" name="cod" class="form-control" id="inputName" value="<?php echo $codg2; ?>" maxlength="11" style="display: none" readonly placeholder="">

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputName">Nombre del Producto</label>
                      <input type="text" name="nom" class="form-control" id="inputName" maxlength="60" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPrice">Precio</label>
                      <input type="text" name="pre" class="form-control" id="inputPrice" placeholder="">
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputState">Duración</label>
                      <input type="number" name="dur" class="form-control" id="inputrice" maxlength="11" placeholder="Duración en Días">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputState">Estado</label>
                      <select id="inputState" name="est" class="form-control">
                        <option value="1">Activo</option>
                        <option value="0">Suspendido</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputState">Categoría</label>
                      <?php require('../basededatos/select.php') ?>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputState">Sabor</label>
                      <select id="inputState" name="sab" class="form-control">
                        <option>Dulce</option>
                        <option>Salado</option>
                        <option>Agridulce</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">Descripción</label>
                        <textarea class="form-control" name="des" id="exampleFormControlTextarea1" maxlength="100" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="form-group">
                        <label for="exampleFormControlFile1">Imagen del Producto</label>
                        <input type="file" name="img" accept="image/*" class="form-control-file" id="exampleFormControlFile1">
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Añadir</button>
                  <button type="button" class="btn btn-danger float-right" style="margin-right: 10px;" onclick="window.location.href='../backend/Productos_Ver.php';">Cancelar</button>

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

          <!-- Validation -->
          <?php require('Validation.php'); ?>
          <!-- End Validation -->

          <script src="vendor/jquery/jquery.min.js"></script>
          <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
          <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
          <script src="js/sb-admin-2.min.js"></script>
          <script src="vendor/datatables/jquery.dataTables.js"></script>
          <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
          <script src="js/demo/datatables-demo.js"></script>

          <script>
            function validateDecimal(input) {
              input.value = input.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
            }
          </script>

        </div>
        <!-- End of Content Wrapper -->

      </div>
      <!-- End of Page Wrapper -->

  </body>

  </html>
<?php }
require('llenar3.php');
?>