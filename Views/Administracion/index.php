<?php include "Views/Templates/header.php"; ?>

<div class="card shadow mb-4">
    <div class="textT card-header bg-primary font-weight-bold text-white text-center">
        DATOS DE LA EMPRESA
    </div>
    <div class="card-body">
        <form id="frmEmpresa">
            <div class="row">
                <!-- ID OCULTO -->
                <input id="id" class="form-control" type="hidden" name="id" value="<?php echo $data['id'] ?>">
                
                <!-- NOMBRE -->
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label for="nombre" class="font-weight-bold">Nombre de la Empresa</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Ingrese el nombre de la empresa" value="<?php echo $data['nombre'] ?>">
                        <div class="invalid-feedback">Solo se permiten letras con acentos y espacios (hasta un máximo de 200 caracteres)!</div>
                    </div>
                </div>
                
                <!-- RUC -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ruc" class="font-weight-bold">RUC</label>
                        <input id="ruc" class="form-control" type="text" name="ruc" placeholder="Ej: 7400254-1" value="<?php echo $data['ruc']; ?>">
                        <div class="invalid-feedback">Solo se permiten números, letras y el guión medio (hasta un máximo de 20 caracteres)!</div>
                    </div>
                </div>
                
                <!-- TELÉFONO -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono" class="font-weight-bold">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Ej: 0992779017" value="<?php echo $data['telefono']; ?>">
                        <div class="invalid-feedback">Solo se permiten números, espacios y los caracteres + y - (hasta un máximo de 16 caracteres)!</div>
                    </div>
                </div>
                
                <!-- DIRECCIÓN -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="direccion" class="font-weight-bold">Dirección</label>
                        <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Ingrese la dirección de la empresa" value="<?php echo $data['direccion']; ?>">
                        <div class="invalid-feedback">Solo se permiten 200 caracteres!</div>
                    </div>
                </div>

                <!-- TIMBRADO -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="timbrado" class="font-weight-bold">Número de Timbrado</label>
                        <input id="timbrado" class="form-control" type="text" name="timbrado" placeholder="Ej: 12345678" value="<?php echo $data['timbrado']; ?>">
                        <div class="invalid-feedback">Solo se permiten números (mínimo 8, máximo 20 caracteres)!</div>
                    </div>
                </div>

                <!-- INICIO DE VIGENCIA -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inicio_vigencia" class="font-weight-bold">Inicio de Vigencia del Timbrado</label>
                        <input id="inicio_vigencia" class="form-control" type="date" name="inicio_vigencia" value="<?php echo $data['inicio_vigencia']; ?>">
                        <div class="invalid-feedback">Debe seleccionar una fecha válida!</div>
                    </div>
                </div>

                <!-- FIN DE VIGENCIA -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fin_vigencia" class="font-weight-bold">Fin de Vigencia del Timbrado</label>
                        <input id="fin_vigencia" class="form-control" type="date" name="fin_vigencia" value="<?php echo $data['fin_vigencia']; ?>">
                        <div class="invalid-feedback">Debe seleccionar una fecha válida y posterior al inicio!</div>
                    </div>
                </div>

                <!-- NÚMERO DE FACTURA INICIAL -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numero_factura_inicial" class="font-weight-bold">Número de Factura Inicial</label>
                        <input id="numero_factura_inicial" class="form-control" type="text" name="numero_factura_inicial" placeholder="Ej: 001-001-0000001" value="<?php echo $data['numero_factura_inicial']; ?>">
                        <div class="invalid-feedback">Formato: 001-001-0000001 (hasta 20 caracteres)!</div>
                    </div>
                </div>

                <!-- MENSAJE -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mensaje" class="font-weight-bold">Mensaje en la Factura</label>
                        <textarea id="mensaje" class="form-control" name="mensaje" rows="3" placeholder="Ej: Gracias por su compra!!"><?php echo $data['mensaje'];?></textarea>
                        <div class="invalid-feedback">Solo se permiten 200 caracteres!</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn btn-danger" type="button" onclick="modificarEmpresa(event)">
                        <i class="fas fa-save"></i> ACTUALIZAR
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>