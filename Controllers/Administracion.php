<?php
class Administracion extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }

    public function index()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermisos($id_user, 'configuracion');
        if (!empty($verificar) || $id_user == 1) {
            $data = $this->model->getEmpresa();
            $this->views->getView($this, "index", $data);
        } else {
            header('Location: ' . base_url . 'Errors/permisos');
        }
    }


    public function auditoria()
    {
        $this->views->getView($this, "auditoria");
    }

    public function factura_detalle()
    {
        $data = $this->model->getfactura();
        $this->views->getView($this, "factura_detalle", $data);
    }



    public function home()
    {
        $data['proveedores'] = $this->model->getDatos('proveedores');
        $data['clientes'] = $this->model->getDatos('clientes');
        $data['productos'] = $this->model->getDatos('productos');
        $data['ventas'] = $this->model->getVentas();
        $this->views->getView($this, "home", $data);
    }

    public function modificar()
    {
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $ruc = $_POST['ruc'];
        $direccion = $_POST['direccion'];
        $mensaje = $_POST['mensaje'];
        $id = $_POST['id'];

        if (!preg_match("/^[a-zA-ZÀ-ÿ0-9 ]{3,200}$/", $nombre)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
        } else if (!preg_match("/^[0-9-+() ]{10,16}$/", $telefono)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
        } else if (!preg_match("/^[0-9a-zA-Z- ]{8,20}$/", $ruc)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
        } else if (!preg_match("/^.{5,200}$/", $direccion)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
        } else if (!preg_match("/^.{0,200}$$/", $mensaje)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
        } else {
            $data = $this->model->modificar($nombre, $telefono, $ruc, $direccion, $mensaje, $id);
            if ($data == 'ok') {
                $msg = array('msg' => 'LOS DATOS DE LA EMPRESA HAN SIDO MODIFICADOS!', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'ERROR AL MODIFICAR LOS DATOS DE LA EMPRESA!', 'icono' => 'error');
            }
        }
        echo json_encode($msg);
        die();
    }

    public function modificarFactura()
    {
        $timbrado = $_POST['timbrado'];
        $inicio_vigencia = $_POST['inicio_vigencia'];
        $fin_vigencia = $_POST['fin_vigencia'];
        $suc_caja = $_POST['suc_caja'];
        $numero_factura = $_POST['numero_factura'];
        $condicion = $_POST['condicion'];
        $iva = $_POST['iva'];
        $id = $_POST['id'];

        if (!preg_match("/^[0-9]{8}$/", $timbrado)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS TIMBRADO!', 'icono' => 'error');
        }  else if (!preg_match("/^[0-9-]{7}$/", $suc_caja)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS SUC!', 'icono' => 'error');
        } else if (!preg_match("/^[0-9]{7}$/", $numero_factura)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS NUMERO!', 'icono' => 'error');
        } else if (!preg_match("/^[A-Z]{7}$/", $condicion)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS CONDICION!', 'icono' => 'error');
        } else if (!preg_match("/^[0-9]{1,2}$/", $iva)) {
            $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS IVA!', 'icono' => 'error');
        } else {
            $data = $this->model->modificarFactura($timbrado, $inicio_vigencia, $fin_vigencia, $suc_caja, $numero_factura, $condicion, $iva, $id);
            if ($data == 'ok') {
                $msg = array('msg' => 'LOS DATOS DE LA EMPRESA HAN SIDO MODIFICADOS!', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'ERROR AL MODIFICAR LOS DATOS DE LA EMPRESA!', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
        
    }

    public function reporteGrafStock()
    {
        $data = $this->model->getStockMinimo();
        echo json_encode($data);
        die();
    }

    public function reporteGrafPVend()
    {
        $data = $this->model->getProdVend();
        echo json_encode($data);
        die();
    }

    public function listar_auditoria()
    {
        $data = $this->model->getAuditoria();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
