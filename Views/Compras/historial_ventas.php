<?php include "Views/Templates/header.php"; ?>

<div class="card shadow mb-4">

    <div class="card-header bg-primary">
        <div class="row">
            <div class="textT col-sm-6 text-left d-flex align-items-center font-weight-bold text-white">HISTORIAL DE VENTAS</div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="display responsive nowrap table" style="width: 100%;" id="t_historial_v">
                <thead class="thead bg-primary">
                    <tr class="text-white">
                        <th>ID</th>
                        <th>Clientes</th>
                        <th>Total</th>
                        <th>Fecha de la Compra</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>