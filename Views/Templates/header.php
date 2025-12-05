<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Carniceria
    </title>

    <!-- Custom fonts for this template-->
    <link rel="icon" href="http://localhost/tesina_kevinAlegre/Views/Templates/imagenes/logo.png" />

    <link href="<?php echo base_url; ?>Assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url; ?>Assets/css/style.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url; ?>Assets/datatables.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url; ?>Assets/responsive.dataTatables.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url; ?>Assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url; ?>Assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="#">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url; ?>Administracion/home">
                <div class="sidebar-brand-icon">
                    <img src="http://localhost/tesina_kevinAlegre/Views/Templates/imagenes/logo.png" alt="Store Logo" class="brand-image img-circle" style="width: 6.8rem;height: 4.8rem;max-height: unset">
                </div>

            </a>

            <hr class="sidebar-divider d-none d-md-block">

            <?php
            if ($_SESSION['nombre'] == 'Administrador') {


            ?>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Administración</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?php echo base_url; ?>Administracion"><i class="fa-solid fa-building mr-2"></i>Empresa</a>
                            <!-- <a class="collapse-item" href="<?php echo base_url; ?>Administracion/factura_detalle"><i class="fa-solid fa-file-invoice mr-2"></i> Factura</a> -->
                            <a class="collapse-item" href="<?php echo base_url; ?>Administracion/auditoria"><i class="fa-solid fa-calculator mr-2"></i>Auditoria</a>
                        </div>
                    </div>
                </li>

            <?php
            }

            ?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCaja" aria-expanded="true" aria-controls="collapseCaja">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>Cajas</span>
                </a>
                <div id="collapseCaja" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url; ?>Cajas"><i class="fas fa-box mr-2"></i>Cajas</a>
                        <a class="collapse-item" href="<?php echo base_url; ?>Cajas/arqueo"><i class="fas fa-tools mr-2"></i>Arqueo de Caja</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url; ?>Proveedores">
                    <i class="fa-solid fa-truck-field"></i>
                    <span>Proveedores</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url; ?>Clientes">
                    <i class="fas fa-users"></i>
                    <span>Clientes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url; ?>Categorias">
                    <i class="fa-solid fa-cart-flatbed"></i>
                    <span>Categorías</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url; ?>Productos">
                    <i class="fa fa-product-hunt"></i>
                    <span>Productos</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url; ?>Usuarios">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Usuarios</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompras" aria-expanded="true" aria-controls="collapseCompras">
                    <i class="fa-brands fa-shopify"></i>
                    <span>Compras</span>
                </a>
                <div id="collapseCompras" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url; ?>Compras"><i class="fa-solid fa-cart-arrow-down mr-2"></i>Nueva Compra</a>
                        <a class="collapse-item" href="<?php echo base_url; ?>Compras/historial"><i class="fas fa-list mr-2"></i>Historial de Compras</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVentas" aria-expanded="true" aria-controls="collapseVentas">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Ventas</span>
                </a>
                <div id="collapseVentas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url; ?>Compras/ventas"><i class="fa-solid fa-cart-plus mr-2"></i>Nueva Venta</a>
                        <a class="collapse-item" href="<?php echo base_url; ?>Compras/historialVentas"><i class="fas fa-list mr-2"></i>Historial de Ventas</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">


            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nombre'] ?></span>
                                <img class="img-profile rounded-circle" src="http://localhost/tesina_kevinAlegre/Views/Templates/imagenes/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#cambiarPass">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cambiar Contraseña
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <main>
                    <div class="container-fluid mt-2">