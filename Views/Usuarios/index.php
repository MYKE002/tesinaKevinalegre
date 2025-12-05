<?php include "Views/Templates/header.php"; ?>
<?php ini_set('display_errors', 1); ?>
<div class="card shadow mb-4">
    <div class="card-header bg-primary">
        <div class="row">
            <div class="textT col-sm-6 text-left d-flex align-items-center font-weight-bold text-white">USUARIOS</div>
            <div class="col-sm-6 text-right">
                <button class="btn btn-danger" type="button" onclick="frmUsuario()">Agregar <i class="m-1 fa-solid fa-circle-plus"></i></button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="display responsive nowrap table " style="width: 100%;" id="tblUsuarios">
                <thead class="thead bg-primary">
                    <tr class="text-white">
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Caja</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="nuevo_usuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-center">
                        <h5 class="modal-title text-white font-weight-bold" id="title">AGREGAR USUARIO</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmUsuario" action="" method="post">
                            <div class="form-group">
                                <label for="usuario" class="font-weight-bold">Usuario</label>
                                <input type="hidden" name="id" id="id">
                                <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario">
                                <div class="invalid-feedback">Solo se permiten números, letras sin acentos, guión medio y guión bajo (hasta un máximo de 20 caracteres)!</div>
                            </div>
                            <div class="form-group">
                                <label for="nombre" class="font-weight-bold">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del Usuario">
                                <div class="invalid-feedback">Solo se permiten letras con acentos y espacios (hasta un máximo de 100 caracteres)!</div>
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="font-weight-bold">Teléfono</label>
                                <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Número de Telefono del Usuario">
                                <div class="invalid-feedback">Solo se permiten numeros, espacios y los caracteres de más y menos (hasta un máximo de 16 caracteres)!</div>
                            </div>
                            <div class="form-group">
                                <label for="correo" class="font-weight-bold">Direccion de Correo</label>
                                <input id="correo" class="form-control" type="email" name="correo" placeholder="Dirección de Correo del Usuario">
                                <div class="invalid-feedback">Por favor ingrese un correo válido!</div>
                            </div>
                            <div class="row" id="claves">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="clave" class="font-weight-bold">Contraseña</label>
                                        <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña">
                                        <div class="invalid-feedback">Por favor ingrese un correo válido!</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" class="font-weight-bold">
                                        <label for="confirmar">Confirmar Contraseña</label>
                                        <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar contraseña">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="caja" class="font-weight-bold">Caja</label>
                                <select id="caja" class="form-control" name="caja">
                                    <?php
                                    foreach ($data['cajas'] as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['caja']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="rol" class="font-weight-bold">Rol</label>
                                <select id="rol" class="form-control" name="rol">
                                    <?php
                                    foreach ($datos['roles'] as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit" onclick="registrarUser(event);" id="btnAccion">Registrar</button>
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