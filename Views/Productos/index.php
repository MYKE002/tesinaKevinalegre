<?php include "Views/Templates/header.php"; ?>
<div class="card shadow mb-4">
    <div class="card-header bg-primary">
        <div class="row">
            <div class="textT col-sm-6 text-left d-flex align-items-center font-weight-bold text-white">PRODUCTOS</div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-danger" type="button" onclick="frmProducto()">Agregar <i class="m-1 fa-solid fa-circle-plus"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="display responsive nowrap table" style="width: 100%;" id="tblProductos">
                <thead class="thead bg-primary">
                    <tr class="text-white">
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="nuevo_producto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="title">Agregar Producto</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmProducto" action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo" class="font-weight-bold">Código</label>
                                        <input type="hidden" name="idP" id="idP">
                                        <input id="codigoP" class="form-control" type="text" name="codigoP" placeholder="Código del producto">
                                        <div class="invalid-feedback">Solo puede contener letras y números sin espacios (hasta un máximo de 20 caracteres)!</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombreP" class="font-weight-bold">Descripción</label>
                                        <input id="nombreP" class="form-control" type="text" name="nombreP" placeholder="Nombre de Producto">
                                        <div class="invalid-feedback">Solo puede tener hasta un máximo de 150 caracteres!</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_compraP" class="font-weight-bold">Precio de Compra</label>
                                        <input id="precio_compraP" class="form-control" type="number" name="precio_compraP" placeholder="Precio de compra">
                                        <div class="invalid-feedback">Solo puede tener números hasta un máximo de 10 dígitos!</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_ventaP" class="font-weight-bold">Precio de Venta</label>
                                        <input id="precio_ventaP" class="form-control" type="number" name="precio_ventaP" placeholder="Precio de venta">
                                        <div class="invalid-feedback">Solo puede tener números hasta un máximo de 10 dígitos!</div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="categoria" class="font-weight-bold">Categorías</label>
                                <select id="categoria" class="form-control" name="categoria">
                                    <?php
                                    foreach ($data['categorias'] as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Foto</label>
                                    <div class="card border-primary text-center">
                                        <div class="card-body">
                                            <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-image"></i></label>
                                            <span id="icon-cerrar"></span>
                                            <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event);">
                                            <input type="hidden" id="foto-actual" name="foto-actual">
                                            <img class="img-thumbnail" id="img-preview" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" type="button" onclick="registrarPro(event);" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include "Views/Templates/footer.php"; ?>