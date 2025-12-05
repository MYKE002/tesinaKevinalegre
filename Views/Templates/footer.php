</div>
</main>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Kevin Alegre 2023 <br> Todos los derechos reservados</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Modal Cerrar Sesión -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">¿Está seguro de cerrar sesión?</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Seleccione "Salir" para cerrar su sesión actual.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger" href="<?php echo base_url; ?>Usuarios/salir">Salir</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="cambiarPass" tabindex="-1" role="dialog" aria-labelledby="cambiarPassLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="cambiarPassLabel">Cambiar Contraseña</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCambiarPass" onsubmit="frmCambiarPass(event);">
                    <div class="form-group">
                        <label for="clave_actual" class="font-weight-bold">Contraseña Actual</label>
                        <input id="clave_actual" class="form-control" type="password" name="clave_actual" placeholder="Contraseña actual" required>
                    </div>
                    <div class="form-group">
                        <label for="clave_nueva" class="font-weight-bold">Nueva Contraseña</label>
                        <input id="clave_nueva" class="form-control" type="password" name="clave_nueva" placeholder="Nueva contraseña" required>
                        <small class="text-muted">Mínimo 6 caracteres</small>
                    </div>
                    <div class="form-group">
                        <label for="confirmar_clave" class="font-weight-bold">Confirmar Nueva Contraseña</label>
                        <input id="confirmar_clave" class="form-control" type="password" name="confirmar_clave" placeholder="Confirmar contraseña" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url; ?>Assets/js/jquery-3.6.3.min.js"></script>
<script src="<?php echo base_url; ?>Assets/bootstrap/js/bootstrap.bundle.min.js"></script>



<!-- Core plugin JavaScript-->
<script src="<?php echo base_url; ?>Assets/jquery-easing/jquery.easing.min.js"></script>

<script src="<?php echo base_url; ?>Assets/js/fontawesome.js"></script>


<!-- Custom scripts for all pages-->
<script src="<?php echo base_url; ?>Assets/js/sb-admin-2.min.js"></script>


<script src="<?php echo base_url; ?>Assets/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url; ?>Assets/datatables.min.js"></script>
<script src="<?php echo base_url; ?>Assets/pdfmake.min.js"></script>
<script src="<?php echo base_url; ?>Assets/vfs_fonts.js"></script>

<script src="<?php echo base_url; ?>Assets/dataTables.responsive.min.js"></script>

<!-- Page level plugins -->
<script src="<?php echo base_url; ?>Assets/chart.js/Chart.min.js"></script>

<script>
    const base_url = "<?php echo base_url; ?>";
</script>

<script src="<?php echo base_url; ?>Assets/js/sweetalert2.all.min.js"></script>

<script src="<?php echo base_url; ?>Assets/js/funciones.js"></script>
<script src="<?php echo base_url; ?>Assets/js/select2.min.js"></script>

</body>

</html>