<?php include "Views/Templates/header.php"; ?>
<div class="card shadow mb-4">
    <div class="card-header bg-primary">
        <div class="row">
            <div class="textT col-sm-6 text-left d-flex align-items-center font-weight-bold text-white">CATEGORÍAS</div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-danger" type="button" onclick="frmCat()">Agregar <i class="m-1 fa-solid fa-circle-plus"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="display responsive nowrap table" style="width: 100%;" id="tblCategorias">
                <thead class="thead bg-primary">
                    <tr class="text-white">
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="nueva_categoria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white font-weight-bold" id="title">Agregar Categoria</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmCat" action="" method="post">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id">
                                <label for="nombre" class="font-weight-bold">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                                <div class="invalid-feedback">Por favor introduzca un nombre con un mínimo de 3 caracteres y un máximo de 50!</div>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" type="button" onclick="registrarCat(event)" id="btnAccion">Registrar</button>
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