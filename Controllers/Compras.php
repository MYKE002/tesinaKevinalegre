<?php
class Compras extends Controller
{
    public function __construct()
    {
        session_start();

        parent::__construct();
    }

    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermisos($id_user, 'nueva_compra');
        if (!empty($verificar) || $id_user == 1) {
            //$this->views->getView($this, "index");
            $datos['categorias'] = $this->model->getCategorias();
            $data = $this->model->getProveedores();
            $this->views->getView($this, "index", $data, $datos);
        } else {
            header('Location: ' . base_url . 'Errors/permisos');
        }
    }

    public function ventas()
    {
        $data = $this->model->getClientes();
        $this->views->getView($this, "ventas", $data);
    }

    public function historialVentas()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermisos($id_user, 'historial_ventas');
        if (!empty($verificar) || $id_user == 1) {
            $this->views->getView($this, "historial_ventas");
        } else {
            header('Location: ' . base_url . 'Errors/permisos');
        }
    }

    public function buscarCodigo($cod)
    {
        $data = $this->model->getProCod($cod);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ingresar()
    {
        $id = $_POST['id'];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos['precio_compra'];
        $cantidad = $_POST['cantidad'];
        $verificar =  $this->model->consultarDetalle('detalles', $id_producto, $id_usuario);
        if (empty($verificar)) {
            $sub_total = $precio * $cantidad;
            $data = $this->model->registrarDetalle('detalles', $id_producto, $id_usuario, $precio, $cantidad, $sub_total);
            if ($data == "ok") {
                $msg = array('msg' => 'PRODUCTO INGRESADO A LA COMPRA!', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'ERROR AL INGRESAR EL PRODUCTO!', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            $total_cantidad = $verificar['cantidad'] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            $data = $this->model->actualizarDetalle('detalles', $precio, $total_cantidad, $sub_total, $id_producto, $id_usuario,);
            if ($data == "modificado") {
                $msg = array('msg' => 'PRODUCTO ACTUALIZADO!', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'ERROR AL ACTUALIZAR EL PRODUCTO!', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function ingresarVenta()
    {
        $id = $_POST['id'];
        $datos = $this->model->getProductos($id);
        $id_producto = $datos['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $datos['precio_venta'];
        $cantidad = $_POST['cantidad'];
        $verificar =  $this->model->consultarDetalle('detalle_temp', $id_producto, $id_usuario);
        if (empty($verificar)) {
            if ($datos['cantidad'] >= $cantidad) {
                $sub_total = $precio * $cantidad;
                $data = $this->model->registrarDetalle('detalle_temp', $id_producto, $id_usuario, $precio, $cantidad, $sub_total);
                if ($data == "ok") {
                    $msg = array('msg' => 'PRODUCTO INGRESADO A LA VENTA!', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'ERROR AL INGRESAR EL VENTA!', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'STOCK NO DISPONIBLE: ' . $datos['cantidad'], 'icono' => 'warning');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            $total_cantidad = $verificar['cantidad'] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            if ($datos['cantidad'] < $total_cantidad) {
                $msg = array('msg' => 'STOCK NO DISPONIBLE!', 'icono' => 'warning');
            } else {
                $data = $this->model->actualizarDetalle('detalle_temp', $precio, $total_cantidad, $sub_total, $id_producto, $id_usuario,);
                if ($data == "modificado") {
                    $msg = array('msg' => 'PRODUCTO ACTUALIZADO!', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'ERROR AL ACTUALIZAR EL PRODUCTO!', 'icono' => 'error');
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function listar($table)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['detalle'] = $this->model->getDetalle($table, $id_usuario);
        $data['total_pagar'] = $this->model->calcularCompra($table, $id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id)
    {
        $data = $this->model->deleteDetalle("detalles", $id);
        if ($data == 'ok') {
            $msg = array('msg' => 'PRODUCTO ELIMINADO CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'EROOR AL ELIMINAR EL PRODUCTO!', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }

    public function deleteVenta($id)
    {
        $data = $this->model->deleteDetalle("detalle_temp", $id);
        if ($data == 'ok') {
            $msg = array('msg' => 'PRODUCTO ELIMINADO CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'EROOR AL ELIMINAR EL PRODUCTO!', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }

    public function registrarCompra($id_proveedor)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->model->calcularCompra('detalles', $id_usuario);
        $data = $this->model->registrarCompra($total['total'], $id_proveedor, $id_usuario);
        if ($data == 'ok') {
            $detalle = $this->model->getDetalle('detalles', $id_usuario);
            $id_compra = $this->model->getId('compras');
            foreach ($detalle as $row) {
                $cantidad = $row['cantidad'];
                $precio = $row['precio'];
                $id_pro = $row['id_producto'];
                $sub_total = $cantidad * $precio;
                $this->model->registrarDetalleCompra($id_compra['id'], $id_pro, $cantidad, $precio, $sub_total);
                $stockActual = $this->model->getProductos($id_pro);
                $stock = $stockActual['cantidad'] + $cantidad;
                $this->model->actualizarStock($stock, $id_pro);
            }
            $vaciar = $this->model->vaciarDetalle('detalles', $id_usuario);
            $msg = 'ok';
            if ($vaciar == 'ok') {
                $msg = array('msg' => 'ok', 'id_compra' => $id_compra['id']);
            }
        } else {
            $msg = 'ERROR AL REALIZAR LA COMPRA';
        }
        echo json_encode($msg);
        die();
    }

    public function registrarVenta($id_cliente)
    {
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarCaja($id_usuario);
        if (empty($verificar)) {
            $msg = array('msg' => 'LA CAJA ESTÁ CERRADA', 'icono' => 'warning');
        } else {
            $total = $this->model->calcularCompra('detalle_temp', $id_usuario);
            $data = $this->model->registrarVenta($id_usuario, $id_cliente, $total['total']);
            if ($data == 'ok') {
                $detalle = $this->model->getDetalle('detalle_temp', $id_usuario);
                $id_venta = $this->model->getId('ventas');
                foreach ($detalle as $row) {
                    $cantidad = $row['cantidad'];
                    $desc = $row['descuento'];
                    $precio = $row['precio'];
                    $id_pro = $row['id_producto'];
                    $sub_total = ($cantidad * $precio) - $desc;
                    $this->model->registrarDetalleVenta($id_venta['id'], $id_pro, $cantidad, $desc, $precio, $sub_total);
                    $stockActual = $this->model->getProductos($id_pro);
                    $stock = $stockActual['cantidad'] - $cantidad;
                    $this->model->actualizarStock($stock, $id_pro);
                }
                $vaciar = $this->model->vaciarDetalle('detalle_temp', $id_usuario);
                $msg = 'ok';
                if ($vaciar == 'ok') {
                    $msg = array('msg' => 'ok', 'id_venta' => $id_venta['id']);
                }
            } else {
                $msg = array('msg' => 'ERROR AL REALIZAR LA VENTA', 'icono' => 'error');
            }
        }

        echo json_encode($msg);
        die();
    }


    public function generarPdf($id_compra)
    {

        $empresa = $this->model->getEmpresa();
        $productos = $this->model->getProCompra($id_compra);
        $proveedor = $this->model->proveedoresCompra($id_compra);


        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', array(125, 240));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);

        //TÍTULO DEL PDF
        $pdf->SetTitle('Reporte de Compras');
        $pdf->SetFont('Arial', 'B', 14);


        //NOMBRE DE LA EMPRESA
        $pdf->Cell(100, 5, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image(base_url . 'Assets/img/logo.png', 93, 8, 30);

        //RUC DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Ruc: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['ruc'], 0, 1, 'L');

        //TELÉFONO DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['telefono'], 0, 1, 'L');

        //DIRECCIÓN DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['direccion'], 0, 1, 'L');



        //FOLIO DE LA COMPRA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Folio:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $id_compra, 0, 1, 'L');

        $pdf->Ln();

        //ENCABEZADO DE PROVEEDOR
        $pdf->SetFillColor(142, 139, 139);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, 'Proveedor', 1, 0, 'L', true);
        $pdf->Cell(25, 5, utf8_decode('Teléfono'), 1, 0, 'L', true);
        $pdf->Cell(46, 5, utf8_decode('Dirección'), 1, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);

        //CONTENIDO PROVEEDORES
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 5, utf8_decode($proveedor['nombre']), 1, 0, 'L');
        $pdf->Cell(25, 5, $proveedor['telefono'], 1, 0, 'L');
        $pdf->Cell(46, 5, utf8_decode($proveedor['direccion']), 1, 1, 'L');

        $pdf->Ln();

        //ENCABEZADO
        $pdf->SetFillColor(142, 139, 139);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(15, 5, 'Cant.', 1, 0, 'L', true);
        $pdf->Cell(45, 5, utf8_decode('Descripción'), 1, 0, 'L', true);
        $pdf->Cell(25, 5, 'Precio', 1, 0, 'L', true);
        $pdf->Cell(26, 5, 'Sub Total', 1, 1, 'L', true);

        $pdf->SetTextColor(0, 0, 0);
        $total = 0;
        foreach ($productos as $row) {
            $total += $row['sub_total'];
            $pdf->Cell(15, 5, $row['cantidad'], 1, 0, 'L');
            $pdf->Cell(45, 5, utf8_decode($row['descripcion']), 1, 0, 'L');
            $pdf->Cell(25, 5, number_format($row['precio'], '0', '.', '.'), 1, 0, 'L');
            $pdf->Cell(26, 5, number_format($row['sub_total'], '0', '.', '.'), 1, 1, 'L');
        }
        $pdf->Ln();
        $pdf->Cell(109, 5, 'Total a Pagar', 0, 1, 'R');
        $pdf->Cell(109, 5, number_format($total, '0', '.', '.') . ' Gs.', 0, 1, 'R');

        $pdf->Output();
    }
    public function generarPdf1($id_compra)
    {

        $empresa = $this->model->getEmpresa();
        $productos = $this->model->getProCompra($id_compra);
        $proveedor = $this->model->proveedoresCompra($id_compra);

        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', array(130, 240));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);

        //TÍTULO DEL PDF
        $pdf->SetTitle('Reporte de Compras');
        $pdf->SetFont('Arial', 'B', 14);

        //NOMBRE DE LA EMPRESA
        $pdf->Cell(100, 5, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image(base_url . 'Assets/img/logo.png', 95, 7, 30);

        //RUC DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Ruc: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['ruc'], 0, 1, 'L');

        //TELÉFONO DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['telefono'], 0, 1, 'L');

        //DIRECCIÓN DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['direccion'], 0, 1, 'L');

        //FOLIO DE LA COMPRA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Folio:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $id_compra, 0, 1, 'L');


        //FOLIO DE LA COMPRA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Comprador: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, ' ' . $proveedor['comprador'], 0, 1, 'L');



        $pdf->Ln();

        //ENCABEZADO DE PROVEEDOR
        $pdf->SetFillColor(142, 139, 139);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, 'Proveedor', 1, 0, 'L', true);
        $pdf->Cell(25, 5, utf8_decode('Teléfono'), 1, 0, 'L', true);
        $pdf->Cell(46, 5, utf8_decode('Dirección'), 1, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);

        //CONTENIDO PROVEEDORES
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 5, utf8_decode($proveedor['nombre']), 1, 0, 'L');
        $pdf->Cell(25, 5, $proveedor['telefono'], 1, 0, 'L');
        $pdf->Cell(46, 5, utf8_decode($proveedor['direccion']), 1, 1, 'L');

        $pdf->Ln();


        //ENCABEZADO
        $pdf->SetFillColor(142, 139, 139);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(15, 5, 'Cant.', 1, 0, 'L', true);
        $pdf->Cell(45, 5, utf8_decode('Descripción'), 1, 0, 'L', true);
        $pdf->Cell(25, 5, 'Precio', 1, 0, 'L', true);
        $pdf->Cell(26, 5, 'Sub Total', 1, 1, 'L', true);

        $pdf->SetTextColor(0, 0, 0);
        $total = 0.00;
        foreach ($productos as $row) {
            $total += $row['sub_total'];
            $pdf->Cell(15, 5, $row['cantidad'], 1, 0, 'L');
            $pdf->Cell(45, 5, utf8_decode($row['descripcion']), 1, 0, 'L');
            $pdf->Cell(25, 5, number_format($row['precio'], '0', '.', '.'), 1, 0, 'L');
            $pdf->Cell(26, 5, number_format($row['sub_total'], '0', '.', '.'), 1, 1, 'L');
        }
        $pdf->Ln();
        $pdf->Cell(109, 5, 'Total a Pagar', 0, 1, 'R');
        $pdf->Cell(109, 5, number_format($total, '0', '.', '.'), 0, 1, 'R');

        $pdf->Output();
    }


    public function historial()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermisos($id_user, 'historial_compras');
        if (!empty($verificar) || $id_user == 1) {
            $this->views->getView($this, "historial");
        } else {
            header('Location: ' . base_url . 'Errors/permisos');
        }
    }

    public function listar_historial()
    {
        $data = $this->model->getHistorialCompras();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Completado</span>';
                $data[$i]['acciones'] = '
                <div>
                    <a class="btn btn-danger" href= "' . base_url . "Compras/generarPdf/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf" ></i></a>
                    <button class="btn btn-warning" onclick="btnAnularC(' . $data[$i]['id'] . ')"><i class="fas fa-ban"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Anulado</span>';
                $data[$i]['acciones'] = '
                <div>
                    <a class="btn btn-danger" href= "' . base_url . "Compras/generarPdf/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf" ></i></a>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listar_historial_venta()
    {
        $data = $this->model->getHistorialVentas();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Completado</span>';
                $data[$i]['acciones'] = '
                <div>
                    <a class="btn btn-danger" href= "' . base_url . "Compras/generarPdfVenta/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf" ></i></a>
                    <button class="btn btn-warning" onclick="btnAnularV(' . $data[$i]['id'] . ')"><i class="fas fa-ban"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Anulado</span>';
                $data[$i]['acciones'] = '
                <div>
                    <a class="btn btn-danger" href= "' . base_url . "Compras/generarPdfVenta/" . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf" ></i></a>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function generarPdfVenta($id_venta)
    {
        $empresa = $this->model->getEmpresa();
        $venta = $this->model->getVenta($id_venta);
        $descuento = $this->model->getDescuento($id_venta);
        $productos = $this->model->getProVenta($id_venta);
        $clientes = $this->model->clientesVenta($id_venta);

        require('Libraries/fpdf/fpdf.php');

        // Inicializar FPDF para 80mm
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetMargins(3, 3, 3);
        $pdf->SetAutoPageBreak(true, 5);

        $ancho_max = 74; // Ancho efectivo (80 - 6mm de márgenes)
        $pdf->SetY(3);

        // ---------------------------------------------------
        // LOGO (OPCIONAL)
        // ---------------------------------------------------
        if (file_exists(base_url . 'Assets/img/logo.png')) {
            $pdf->Image(base_url . 'Assets/img/logo.png', 25, $pdf->GetY(), 30);
            $pdf->Ln(20);
        }

        // ---------------------------------------------------
        // ENCABEZADO DE LA EMPRESA
        // ---------------------------------------------------
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($ancho_max, 5, utf8_decode($empresa['nombre']), 0, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($ancho_max, 4, 'RUC: ' . utf8_decode($empresa['ruc']), 0, 1, 'C');
        $pdf->MultiCell($ancho_max, 3, utf8_decode($empresa['direccion']), 0, 'C');
        $pdf->Cell($ancho_max, 3, utf8_decode('Tel: ' . $empresa['telefono']), 0, 1, 'C');

        $pdf->Ln(2);

        // Línea separadora
        $pdf->Cell($ancho_max, 0, '', 'T', 1);
        $pdf->Ln(2);

        // ---------------------------------------------------
        // DATOS DE TIMBRADO Y FACTURA (DINÁMICOS)
        // ---------------------------------------------------
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($ancho_max, 4, 'TIMBRADO: ' . utf8_decode($empresa['timbrado']), 0, 1, 'C');

        // Formatear fechas de vigencia
        $fecha_inicio = date('d/m/Y', strtotime($empresa['inicio_vigencia']));
        $fecha_fin = date('d/m/Y', strtotime($empresa['fin_vigencia']));

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell($ancho_max, 3, 'Inicio Vigencia: ' . $fecha_inicio, 0, 1, 'C');
        $pdf->Cell($ancho_max, 3, 'Fin Vigencia: ' . $fecha_fin, 0, 1, 'C');

        $pdf->Ln(2);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($ancho_max, 5, 'FACTURA', 0, 1, 'C');

        // Generar número de factura dinámico
        // Extraer el formato base del número inicial (ej: "001-001")
        $partes_factura = explode('-', $empresa['numero_factura_inicial']);
        $establecimiento = $partes_factura[0]; // 001
        $punto_expedicion = $partes_factura[1]; // 001

        // Número correlativo (puede venir de la venta o calcularse)
        // Si tu tabla venta tiene un campo numero_factura, úsalo; si no, usa el id_venta
        $numero_correlativo = isset($venta['numero_factura']) ? $venta['numero_factura'] : $id_venta;
        $numero_factura = $establecimiento . '-' . $punto_expedicion . '-' . str_pad($numero_correlativo, 7, '0', STR_PAD_LEFT);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($ancho_max, 4, utf8_decode('N° ' . $numero_factura), 0, 1, 'C');

        $pdf->Ln(2);
        $pdf->Cell($ancho_max, 0, '', 'T', 1);
        $pdf->Ln(2);

        // ---------------------------------------------------
        // DATOS DE LA VENTA
        // ---------------------------------------------------
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell($ancho_max / 2, 4, utf8_decode('Fecha: ') . utf8_decode($venta['fecha']), 0, 0, 'L');
        $pdf->Cell($ancho_max / 2, 4, utf8_decode('Cond: CONTADO'), 0, 1, 'R');

        $pdf->Ln(2);

        // ---------------------------------------------------
        // DATOS DEL CLIENTE
        // ---------------------------------------------------
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($ancho_max, 4, 'DATOS DEL CLIENTE', 0, 1, 'L');

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(16, 3, 'Cliente:', 0, 0, 'L');
        $pdf->MultiCell($ancho_max - 16, 3, utf8_decode($clientes['nombre']), 0, 'L');

        $pdf->Cell(16, 3, 'RUC/CI:', 0, 0, 'L');
        $pdf->Cell($ancho_max - 16, 3, utf8_decode($clientes['cedula']), 0, 1, 'L');

        $pdf->Cell(16, 3, utf8_decode('Dirección:'), 0, 0, 'L');
        $pdf->MultiCell($ancho_max - 16, 3, utf8_decode($clientes['direccion']), 0, 'L');

        $pdf->Ln(2);
        $pdf->Cell($ancho_max, 0, '', 'T', 1);
        $pdf->Ln(2);

        // ---------------------------------------------------
        // TABLA DE PRODUCTOS
        // ---------------------------------------------------
        $pdf->SetFont('Arial', 'B', 7);

        // Columnas: CANT | DESCRIPCION | P.UNIT | TOTAL
        $w = array(8, 34, 16, 16);

        $pdf->Cell($w[0], 4, 'CNT', 1, 0, 'C');
        $pdf->Cell($w[1], 4, utf8_decode('DESCRIPCIÓN'), 1, 0, 'C');
        $pdf->Cell($w[2], 4, 'P.UNIT', 1, 0, 'C');
        $pdf->Cell($w[3], 4, 'TOTAL', 1, 1, 'C');

        // Productos
        $pdf->SetFont('Arial', '', 7);
        $total = 0;
        $totDesc = 0;
        $totalIva5 = 0;
        $totalIva10 = 0;
        $totalExenta = 0;

        foreach ($productos as $row) {
            $total += $row['sub_total'];
            $totDesc += $row['descuento'];

            // Si tu tabla productos tiene un campo tipo_iva, úsalo aquí
            // Por defecto asumo IVA 10%
            $totalIva10 += $row['sub_total'];

            // Cantidad
            $pdf->Cell($w[0], 4, $row['cantidad'], 1, 0, 'C');

            // Descripción - puede ser multilínea
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->MultiCell($w[1], 4, utf8_decode($row['descripcion']), 1, 'L');
            $height = $pdf->GetY() - $y;

            // Precio unitario y Total alineados con la descripción
            $pdf->SetXY($x + $w[1], $y);
            $pdf->Cell($w[2], $height, number_format($row['precio'], 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell($w[3], $height, number_format($row['sub_total'], 0, ',', '.'), 1, 1, 'R');

            // Mostrar descuento si existe
            if ($row['descuento'] > 0) {
                $pdf->SetFont('Arial', 'I', 6);
                $pdf->Cell($w[0], 3, '', 0, 0);
                $pdf->Cell($w[1] + $w[2] - 10, 3, 'Descuento:', 0, 0, 'R');
                $pdf->Cell(10, 3, '-' . number_format($row['descuento'], 0, ',', '.'), 0, 1, 'R');
                $pdf->SetFont('Arial', '', 7);
            }
        }

        $pdf->Ln(2);

        // ---------------------------------------------------
        // RESUMEN DE TOTALES
        // ---------------------------------------------------

        // Subtotal (antes de descuentos)
        if ($totDesc > 0) {
            $subtotal_antes = $total + $totDesc;
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell($ancho_max - 20, 4, 'Subtotal:', 0, 0, 'R');
            $pdf->Cell(20, 4, number_format($subtotal_antes, 0, ',', '.'), 0, 1, 'R');

            $pdf->Cell($ancho_max - 20, 4, 'Descuento:', 0, 0, 'R');
            $pdf->Cell(20, 4, '- ' . number_format($totDesc, 0, ',', '.'), 0, 1, 'R');

            $pdf->Ln(1);
        }

        // TOTAL A PAGAR
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($ancho_max - 20, 6, 'TOTAL:', 0, 0, 'R');
        $pdf->Cell(20, 6, number_format($total, 0, ',', '.') . ' Gs', 0, 1, 'R');

        $pdf->Ln(2);

        // Total en letras
        if (file_exists("CifrasEnLetras.php")) {
            require_once "CifrasEnLetras.php";
            $v = new CifrasEnLetras();
            $cifra = $v->convertirCifrasEnLetras($total);

            $pdf->SetFont('Arial', 'I', 7);
            $pdf->MultiCell($ancho_max, 3, 'SON: ' . strtoupper(utf8_decode($cifra)) . ' GUARANIES', 0, 'C');
            $pdf->Ln(1);
        }

        $pdf->Cell($ancho_max, 0, '', 'T', 1);
        $pdf->Ln(2);

        // ---------------------------------------------------
        // LIQUIDACIÓN DEL IVA
        // ---------------------------------------------------
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($ancho_max, 4, utf8_decode('LIQUIDACIÓN DEL IVA'), 0, 1, 'C');

        $pdf->SetFont('Arial', '', 7);

        // IVA 10%
        if ($totalIva10 > 0) {
            $base_iva10 = $totalIva10 / 1.1; // Base gravada
            $monto_iva10 = $totalIva10 - $base_iva10; // Monto del IVA

            $pdf->Cell($ancho_max / 2, 3, 'Gravadas 10%:', 0, 0, 'L');
            $pdf->Cell($ancho_max / 2, 3, number_format($base_iva10, 0, ',', '.'), 0, 1, 'R');

            $pdf->Cell($ancho_max / 2, 3, 'IVA 10%:', 0, 0, 'L');
            $pdf->Cell($ancho_max / 2, 3, number_format($monto_iva10, 0, ',', '.'), 0, 1, 'R');
        }

        // IVA 5%
        if ($totalIva5 > 0) {
            $base_iva5 = $totalIva5 / 1.05;
            $monto_iva5 = $totalIva5 - $base_iva5;

            $pdf->Cell($ancho_max / 2, 3, 'Gravadas 5%:', 0, 0, 'L');
            $pdf->Cell($ancho_max / 2, 3, number_format($base_iva5, 0, ',', '.'), 0, 1, 'R');

            $pdf->Cell($ancho_max / 2, 3, 'IVA 5%:', 0, 0, 'L');
            $pdf->Cell($ancho_max / 2, 3, number_format($monto_iva5, 0, ',', '.'), 0, 1, 'R');
        }

        // Exentas
        if ($totalExenta > 0) {
            $pdf->Cell($ancho_max / 2, 3, 'Exentas:', 0, 0, 'L');
            $pdf->Cell($ancho_max / 2, 3, number_format($totalExenta, 0, ',', '.'), 0, 1, 'R');
        }

        // Total IVA
        $total_iva = ($totalIva10 > 0 ? ($totalIva10 - ($totalIva10 / 1.1)) : 0) +
            ($totalIva5 > 0 ? ($totalIva5 - ($totalIva5 / 1.05)) : 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell($ancho_max / 2, 3, 'Total IVA:', 0, 0, 'L');
        $pdf->Cell($ancho_max / 2, 3, number_format($total_iva, 0, ',', '.'), 0, 1, 'R');

        $pdf->Ln(3);
        $pdf->Cell($ancho_max, 0, '', 'T', 1);
        $pdf->Ln(2);

        // ---------------------------------------------------
        // PIE DE PÁGINA (MENSAJE DINÁMICO)
        // ---------------------------------------------------
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell($ancho_max, 3, utf8_decode($empresa['mensaje']), 0, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 6);
        $pdf->MultiCell($ancho_max, 3, utf8_decode('Original: Cliente - Duplicado: Emisor'), 0, 'C');
        $pdf->MultiCell($ancho_max, 3, utf8_decode('Documento válido como comprobante de crédito fiscal'), 0, 'C');

        // Espacio para corte
        $pdf->Ln(8);

        $pdf->Output();
    }


    public function generarPdfVenta1($id_venta)
    {

        $empresa = $this->model->getEmpresa();
        $descuento = $this->model->getDescuento($id_venta);
        $productos = $this->model->getProVenta($id_venta);

        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', array(120, 240));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);

        //TÍTULO DEL PDF
        $pdf->SetTitle('Reporte de Ventas');
        $pdf->SetFont('Arial', 'B', 14);


        //NOMBRE DE LA EMPRESA
        $pdf->Cell(100, 5, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image(base_url . 'Assets/img/logo.png', 85, 13, 30);

        //RUC DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Ruc: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['ruc'], 0, 1, 'L');

        //TELÉFONO DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['telefono'], 0, 1, 'L');

        //DIRECCIÓN DE LA EMPRESA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $empresa['direccion'], 0, 1, 'L');

        //FOLIO DE LA COMPRA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 5, 'Folio:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, $id_venta, 0, 1, 'L');

        $pdf->Ln();

        //ENCABEZADO DE CLIENTES
        $pdf->SetFillColor(142, 139, 139);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, 'Nombre Cliente', 1, 0, 'L', true);
        $pdf->Cell(25, 5, utf8_decode('Teléfono'), 1, 0, 'L', true);
        $pdf->Cell(46, 5, utf8_decode('Dirección'), 1, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);

        //CONTENIDO CLIENTES
        $pdf->SetFont('Arial', '', 9);
        $clientes = $this->model->clientesVenta($id_venta);
        $pdf->Cell(40, 5, utf8_decode($clientes['nombre']), 1, 0, 'L');
        $pdf->Cell(25, 5, $clientes['telefono'], 1, 0, 'L');
        $pdf->Cell(46, 5, utf8_decode($clientes['direccion']), 1, 1, 'L');


        $pdf->Ln();


        //ENCABEZADO DE PRODUCTOS
        $pdf->SetFillColor(142, 139, 139);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(15, 5, 'Cant.', 1, 0, 'L', true);
        $pdf->Cell(45, 5, utf8_decode('Descripción'), 1, 0, 'L', true);
        $pdf->Cell(25, 5, 'Precio', 1, 0, 'L', true);
        $pdf->Cell(26, 5, 'Sub Total', 1, 1, 'L', true);

        $pdf->SetTextColor(0, 0, 0);
        $total = 0.00;
        foreach ($productos as $row) {
            $total = $total + $row['sub_total'];
            $pdf->Cell(15, 5, $row['cantidad'], 1, 0, 'L');
            $pdf->Cell(45, 5, utf8_decode($row['descripcion']), 1, 0, 'L');
            $pdf->Cell(25, 5, $row['precio'], 1, 0, 'L');
            $pdf->Cell(26, 5, number_format($row['sub_total'], 2, ',', '.'), 1, 1, 'L');
        }
        $pdf->Ln();
        $pdf->Cell(109, 5, 'Descuento Total', 0, 1, 'R');
        $pdf->Cell(109, 5, number_format($descuento['total'], '2', ',', '.'), 0, 1, 'R');

        $pdf->Cell(109, 5, 'Total a Pagar', 0, 1, 'R');
        $pdf->Cell(109, 5, number_format($total, '2', ',', '.'), 0, 1, 'R');



        $pdf->Output();
    }

    public function calcularDescuento($datos)
    {
        $array = explode(',', $datos);
        $id = $array[0];
        $desc = $array[1];
        if (empty($id) || empty($desc)) {
            $msg = array('msg' => 'ERROR!', 'icono' => 'error');
        } else {
            $desc_actual = $this->model->verificarDesc($id);
            $desc_total = $desc_actual['descuento'] + $desc;
            $sub_total = ($desc_actual['cantidad'] * $desc_actual['precio']) - $desc_total;
            $data = $this->model->actualizarDescuento($desc_total, $sub_total, $id);
            if ($data == 'ok') {
                $msg = array('msg' => 'DESCUENTO APLICADO!', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'ERROR AL APLICAR EL DESCUENTO!', 'icono' => 'success');
            }
        }
        echo json_encode($msg);
        die();
    }

    public function anularCompra($id_compra)
    {
        $data = $this->model->getAnularCompra($id_compra);
        $anular = $this->model->getAnular($id_compra);
        foreach ($data as $row) {
            $stockActual = $this->model->getProductos($row['id_producto']);
            $stock = $stockActual['cantidad'] - $row['cantidad'];
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok') {
            $msg = array('msg' => 'COMPRA ANULADA!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL ANULAR LA COMPRA!', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }

    public function anularVenta($id_venta)
    {
        $data = $this->model->getAnularVenta($id_venta);
        $anular = $this->model->getAnularV($id_venta);
        foreach ($data as $row) {
            $stockActual = $this->model->getProductos($row['id_producto']);
            $stock = $stockActual['cantidad'] + $row['cantidad'];
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        if ($anular == 'ok') {
            $msg = array('msg' => 'VENTA ANULADA!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL ANULAR LA VENTA!', 'icono' => 'error');
        }
        echo json_encode($msg);
        die();
    }
}
