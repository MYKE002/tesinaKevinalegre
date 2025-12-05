<?php include "Views/Templates/header.php"; ?>

<div class="card shadow mb-4">
    <div class="card-header bg-primary d-flex justify-content-center text-white font-weight-bold">
        <h4 class="font-weight-bold d-flex align-items-center mb-1 mt-1">NUEVA VENTA</h4>
    </div>
    <div class="card-body">
        <form id="frmVenta">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <label for="codigo" class="font-weight-bold"> <i class="fas fa-barcode"></i> Código de Barras <a class="font-weight-bold" type="button" title="Buscar Producto" onclick="listaProductos()"><i class="fa-solid fa-magnifying-glass font-weight-bold"></i></a></label>
                        <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Código de Barras del Producto" onkeyup="buscarCodigoVenta(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="nombre" class="font-weight-bold">Descripción</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Descripción del producto" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cantidad" class="font-weight-bold">Cantidad</label>
                        <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cantidad" onkeyup="calcularPrecioVenta(event)" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="precio" class="font-weight-bold">Precio</label>
                        <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio de Venta" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sub-total" class="font-weight-bold">Sub Total</label>
                        <input id="sub-total" class="form-control" type="text" name="sub-total" placeholder="Sub Total" disabled>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cliente" class="font-weight-bold">Seleccionar Cliente</label>
                        <select id="cliente" class="form-control " name="cliente" >
                            <?php foreach ($data as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="display responsive nowrap table" style="width: 100%;">
            <thead class="thead bg-primary">
                <tr class="text-white">
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Aplicar</th>
                    <th>Descuento</th>
                    <th>Precio</th>
                    <th>Sub Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tblDetalleVenta">
            </tbody>
        </table>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-4 ml-auto">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="total" class="font-weight-bold">TOTAL A PAGAR</label>
                    <input id="total" class="form-control" type="text" name="total" placeholder="Total" disabled>
                    <button class="btn btn-primary mt-2 btn-block" type="button" onclick="procesar(0)">Generar Venta</button>
                </div>
            </div>
        </div>
    </div>

    
    <div id="modal_productos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="my-modal-title title">Productos</h5>
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