<?php include "Views/Templates/header.php"; ?>

<div class="col-md-8 mx-auto">
    <div class="card">
        <div class="card-header text-center bg-dark text-white">
            ASIGNAR PERMISOS
        </div>
        <div class="card-body">
            <form id="formulario" onsubmit="registrarPermisos(event)">
                <div class="row">
                    <?php foreach ($data['datos'] as $row) { ?>
                        <div class="col-md-4 text-center text-capitalize p-2">
                            <label class="content-input" >
                                <?php echo $row['permiso']; ?>
                                <input type="checkbox" name="permisos[]" value="<?php echo $row['id']; ?>" <?php echo isset($data['asignados'][$row['id']]) ? 'checked' : '' ?>><i></i>
                            </label>
                        </div>
                    <?php } ?>
                    <input type="hidden" value="<?php echo $data['id_usuario'];?>" name="id_usuario">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-primary">Asignar Permisos</button>
                    <a class="btn btn-outline-danger" href="<?php echo base_url; ?>Usuarios">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?> 