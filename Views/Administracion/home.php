<?php include "Views/Templates/header.php"; ?>

<!-- INICIO -->
<div class="d-sm-flex align-items-center justify-content-between ">
    <h1 class="h3 mb-0 text-gray-800">INICIO</h1>
    <?php
        date_default_timezone_set('America/Asuncion');
        $dayNum = date('N');
        $dayL = date('d');
        $month = date('m');
        $year = date('Y');
        $hour = date('h:m');
        
        
        $mes = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
        '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');

        $dia = [' ', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        echo $dia[$dayNum] . ', ' . $dayL. ' de '. $mes[$month] . ' del '. $year;
    ?>

</div>
<hr class="sidebar-divider d-none d-md-block mb-4 mt-2">


<div class="row">
    <!-- PROVEEDORES CARD -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Proveedores</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span><?php echo $data['proveedores']['total'] ?></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between text-primary">
                <a href="<?php echo base_url; ?>Proveedores" class="link text-primary">
                    Ver detalles  
                </a>
                <a href="<?php echo base_url; ?>Proveedores"><i class="fa fa-arrow-right text-primary"></i></a>
            </div>
        </div>
    </div>

    <!-- CLIENTES CARD -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            CLIENTES</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span><?php echo $data['clientes']['total'] ?></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-success"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between text-success">
                <a href="<?php echo base_url; ?>Clientes" class="link text-success">
                    Ver detalles  
                </a>
                <a href="<?php echo base_url; ?>Clientes"><i class="fa fa-arrow-right text-success"></i></a>
            </div>
        </div>
    </div>

    <!-- PRODUCTOS CARD -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h6 font-weight-bold text-danger text-uppercase mb-1">
                           PRODUCTOS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span><?php echo $data['productos']['total'] ?></span>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fab fa-product-hunt fa-2x text-danger"></i>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between text-danger">
                <a href="<?php echo base_url; ?>Productos" class="link text-danger">
                    Ver detalles  
                </a>
                <a href="<?php echo base_url; ?>Productos"><i class="fa fa-arrow-right text-danger "></i></a>
            </div>
        </div>

    </div>

    <!-- VENTAS DIARIAS CARD -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Ventas del día</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span><?php echo $data['ventas']['total'] ?></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cash-register fa-2x text-info"></i>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between text-info">
                <a href="<?php echo base_url; ?>Compras/historialVentas" class="link text-info">
                    Ver detalles  
                </a>
                <a href="<?php echo base_url; ?>Compras/historialVentas"><i class="fa fa-arrow-right text-info"></i></a>
            </div>
        </div>

    </div>
</div>


<div class="row">

    <!-- Stock Mínimo Chart -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">PRODUCTOS CON STOCK MÍNIMO</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="stockMinimo" style="display: block; height: 253px; width: 364px;" class="chartjs-render-monitor" width="455" height="316"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos Más Vendidos Chart -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">PRODUCTOS MÁS VENDIDOS</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="productosVendidos" style="display: block; height: 253px; width: 364px;" class="chartjs-render-monitor" width="455" height="316"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>




<?php include "Views/Templates/footer.php"; ?>