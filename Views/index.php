<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>
    <link rel="icon" href="http://localhost/tesina_kevinAlegre/Views/Templates/imagenes/logo.png" />
    <link rel="shortcut icon" href="#">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url; ?>Assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url; ?>Assets/css/style.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url; ?>Assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-info">
    <div class="login container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="lol card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body Views/Templates/img/logo.png-->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"> 
                            <img class="w-100" src="Views/Templates/imagenes/iniciar.png" alt="LOGO EMPRESA">
                            </div>
                            <div class=" col-lg-6">
                                
                                <div class="p-5">
                                    <div class="text-center">
                                        <img class="w-100" src="Views/Templates/imagenes/logo.png" alt="LOGO EMPRESA">
                                    </div>
                                    <div class="text-center">
                                        <h1 class="title_login h5 text-bold text-gray-900 mb-4">inicie sesion</h1>
                                    </div>
                                    <form id="frmLogin" class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="usuario" name="usuario" aria-describedby="emailHelp" placeholder="Ingrese usuario">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="clave" name="clave" placeholder="Ingrese contraseña">
                                        </div>

                                        <div class="alert alert-danger text-center d-none" role="alert" id="alerta">

                                        </div>

                                        <button class="btn btn-primary btn-user btn-block" type="submit" onclick="frmLogin(event);">Ingresar</button>

                                        <hr>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

     <!--Bootstrap core JavaScript-->
    <script src="<?php echo base_url; ?>Assets/jquery/jquery.min.js" ></script>
    <script src="<?php echo base_url; ?>Assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url; ?>Assets/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url; ?>Assets/js/sb-admin-2.min.js"></script>

    <script src="<?php echo base_url; ?>Assets/js/datatables/jquery.dataTables.min.js"></script> 
    <script src="<?php echo base_url; ?>Assets/js/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        const base_url = "<?php echo base_url; ?>";
    </script>

    <script src="<?php echo base_url; ?>Assets/js/login.js"></script>


</body>

</html>