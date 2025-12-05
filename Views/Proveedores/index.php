<?php include "Views/Templates/header.php"; ?>
<div class="card shadow mb-4">
    <div class="card-header bg-primary">
        <div class="row">
            <div class="textT col-sm-6 text-left d-flex align-items-center font-weight-bold text-white">PROVEEDORES</div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-danger" type="button" onclick="frmProveedor()">Agregar <i class="m-1 fa-solid fa-circle-plus"></i></button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="display responsive nowrap table" style="width: 100%;" id="tblProveedores">
                <thead class="thead bg-primary">
                    <tr class="text-white">
                        <th>ID</th>
                        <th>RUC</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="nuevo_proveedor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white font-weight-bold" id="title">Agregar Proveedor</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmProveedor" action="" method="post">
                            <div class="form-group">
                                <label for="ruc" class="font-weight-bold">RUC</label>
                                <input type="hidden" name="id" id="id">
                                <input id="ruc" class="form-control" type="text" name="ruc" placeholder="RUC del Proveedor" require>
                                <div class="invalid-feedback">Solo se permiten números, letras sin acentos, guión bajo y espacios (hasta un máximo de 20 caracteres)!</div>
                            </div>
                            <div class="form-group">
                                <label for="nombre" class="font-weight-bold">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del Proveedor" require>
                                <div class="invalid-feedback">Solo se permiten letras y espacios (hasta un máximo de 100 caracteres)!</div>
                            </div>

                            <div class="form-group">
                                <label for="telefono" class="font-weight-bold">Teléfono</label>
                                <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Número de teléfono" require>
                                <div class="invalid-feedback">Por favor introduzca un número de teléfono válido!</div>
                            </div>

                            <div class="form-group">
                                <label for="correo" class="font-weight-bold">Direccion de Correo</label>
                                <input id="correo" class="form-control" type="text" name="correo" placeholder="Correo electrónico del Proveedor">
                                <div class="invalid-feedback">Por favor introduzca un correo electrónico válido!</div>
                            </div>

                            <div class="form-group">
                                <label for="direccion" class="font-weight-bold">Dirección</label>
                                <textarea id="direccion" class="form-control" name="direccion" rows="3" placeholder="Dirección del Proveedor" require></textarea>
                                <div class="invalid-feedback">Por favor introduzca una direccion válida (hasta un máximo de 200 caracteres)!</div>
                            </div>

                            <div class="text-right">
                                <button class="btn btn-primary" type="button" onclick="registrarProv(event)" id="btnAccion">Registrar</button>
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