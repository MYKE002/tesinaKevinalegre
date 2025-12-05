<?php include "Views/Templates/header.php"; ?>
<div class="card shadow mb-4">
    <div class="card-header bg-primary">
        <div class="row">
            <div class="textT col-sm-6 text-left d-flex align-items-center font-weight-bold text-white">ARQUEO DE CAJA</div>
            <div class="col-sm-6 text-right">

                <button id="abrir" class="btn btn-warning" type="button" onclick="arqueoCaja();">Abrir Caja<i class="m-1 fa-solid fa-circle-plus"></i></button>
                <button id="cerrar" class="btn btn-danger" type="button" onclick="cerrarCaja();">Cerrar Caja<i class="m-1 fa-solid fa-circle-xmark"></i></button>

            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="display responsive nowrap table" style="width: 100%;" id="tArqueo">
                <thead class="thead bg-primary">
                    <tr class="text-white">
                        <th>ID</th>
                        <th>Monto Inicial</th>
                        <th>Monto Final</th>
                        <th>Fecha de Apertura</th>
                        <th>Fecha de Cierre</th>
                        <th>Total Ventas</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="abrir_caja" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white font-weight-bold" id="title">Arqueo Caja</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmAbrirCaja" method="post" onsubmit="abrirArqueo(event)">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id">
                                <label for="monto_inicial" class="font-weight-bold">Monto Inicial</label>
                                <input id="monto_inicial" class="form-control" type="number" name="monto_inicial" placeholder="Monto Inicial de la Caja" require>
                                <div class="invalid-feedback">Solo se permiten números enteros (hasta un máximo de 10 caracteres)!</div>
                            </div>
                            <div id="ocultar_campos">
                                <div class="form-group">
                                    <label for="monto_final" class="font-weight-bold">Monto Final</label>
                                    <input id="monto_final" class="form-control" type="text" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="total_ventas" class="font-weight-bold">Total Ventas</label>
                                    <input id="total_ventas" class="form-control" type="text" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="monto_general" class="font-weight-bold">Monto Total</label>
                                    <input id="monto_general" class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit" id="btnAccion">Abrir</button>
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