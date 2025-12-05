<?php include "Views/Templates/header.php"; ?>

<div class="card shadow mb-4">
    <div class="card-header bg-primary d-flex justify-content-center text-white font-weight-bold">
        <h4 class="font-weight-bold d-flex align-items-center mb-1 mt-1">NUEVA COMPRA</h4>
    </div>
    <div class="card-body">
        <form id="frmCompra">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <label class="font-weight-bold" for="codigo" style="width: 100%;"> <i class="fas fa-barcode"></i> Código de Barras <a class="font-weight-bold" title="Agregar Nuevo Producto" onclick="frmProducto()"><i class="fas fa-plus-circle"></i></a>  
                            <a class="font-weight-bold" type="button" title="Buscar Producto" onclick="listaProductos()"><i class="fa-solid fa-magnifying-glass font-weight-bold"></i></a>
                        </label>
                        <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Código de Barras del Producto" onkeyup="buscarCodigo(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="font-weight-bold" for="nombre">Descripción</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Descripción del producto" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="font-weight-bold" for="cantidad">Cantidad</label>
                        <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cantidad" onkeyup="calcularPrecio(event)" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="font-weight-bold" for="precio">Precio</label>
                        <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio de compra" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="font-weight-bold" for="sub-total">Sub Total</label>
                        <input id="sub-total" class="form-control" type="text" name="sub-total" placeholder="Sub Total" disabled>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="proveedor" class="font-weight-bold">Seleccionar Proveedor</label>
                        <select id="proveedor" class="form-control " name="proveedor" >
                            <?php foreach ($data as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive ">
        <table class="display responsive nowrap table" style="width: 100%;">
            <thead class="thead bg-primary">
                <tr class="text-white">
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Sub Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tblDetalle">
            </tbody>
        </table>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 ml-auto">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="total" class="font-weight-bold">TOTAL</label>
                    <input id="total" class="form-control" type="text" name="total" placeholder="Total de la compra" disabled>
                    <button class="btn btn-primary mt-2 btn-block" type="button" onclick="procesar(1)">Generar Compra</button>
                </div>
            </div>
        </div>
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
                                    <label for="codigoP" class="font-weight-bold">Código</label>
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
                                foreach ($datos['categorias'] as $row) { ?>
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


    
    <div id="modal_productos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="my-modal-title title">PRODUCTOS</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="table-responsive p-2">
                    <table class="display responsive nowrap table" style="width: 100%;" id="tblProductosLista">
                        <thead class="thead bg-primary">
                            <tr class="text-white">
                                <th>Foto</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>