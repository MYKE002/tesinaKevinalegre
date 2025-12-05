<?php

class Cajas extends Controller
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
        $verificar = $this->model->verificarPermisos($id_user, 'cajas');
        if (!empty($verificar) || $id_user == 1 ) {
            $this->views->getView($this, "index");
        } else {
            header('Location: '.base_url. 'Errors/permisos');
        }
    }

    public function arqueo()
    {
        $this->views->getView($this, "arqueo");
    }


    

    public function listar()
    {
        $data = $this->model->getCajas('cajas');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button title = "Editar" class="btn btn-primary" type="button" onclick="btnEditarCaja(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                    <button title = "Eliminar" class="btn btn-danger" type="button" onclick="btnEliminarCaja(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button class="btn btn-success" type="button" onclick="btnReactivarCaja(' . $data[$i]['id'] . ');">Reactivar</button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $caja = $_POST['caja'];
        $id = $_POST['id'];

        if (empty($caja)) {
            $msg = array('msg' => 'CAMPO OBLIGATORIO!', 'icono' => 'warning');
        } else { 
            if ($id == "") {
                if(!preg_match("/^[a-zA-Z0-9_-]{3,20}$/",$caja)){
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                }else{
                    $data = $this->model->registrarCaja($caja);
                    if ($data == "ok") {
                        $msg = array('msg' => 'CAJA REGISTRADA CON ÉXITO!', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'LA CAJA YA EXISTE!', 'icono' => 'warning');
                    } else {
                        $msg = array('msg' => 'ERROR AL REGISTRAR LA CAJA!', 'icono' => 'error');
                    }
                }
            } else {
                if (!preg_match("/^[a-zA-Z0-9_-]{3,20}$/", $caja)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else {
                    $data = $this->model->modificarCaja($caja, $id);
                    if ($data == "modificado") {
                        $msg = array('msg' => 'CAJA MODIFICADA CON ÉXITO!', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'ERROR AL MODIFICAR LA CAJA!', 'icono' => 'error');
                    }
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function editar(int $id)
    {
        $data = $this->model->editarCaja($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {
        $data = $this->model->accionCaja(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'CAJA DESACTIVADA CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL ELIMINAR LA CAJA!', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivar(int $id)
    {
        $data = $this->model->accionCaja(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'CAJA REINGRESADA CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL REINGRESAR LA CAJA!', 'icono' => 'success');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    

    public function abrirArqueo()
    {
        date_default_timezone_set('America/Asuncion');
        $monto_inicial = $_POST['monto_inicial'];
        $fecha_apertura = date('Y-m-d H:i:s');
        $id_usuario = $_SESSION['id_usuario'];
        $id = $_POST['id'];
        if (empty($monto_inicial)) {
            $msg = array('msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS!', 'icono' => 'warning');
        } else {
            if ($id == '') {
                $data = $this->model->registrarArqueo($id_usuario, $monto_inicial, $fecha_apertura);
                if ($data == "ok") {
                    $msg = array('msg' => 'CAJA ABIERTA CON ÉXITO!', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'LA CAJA YA ESTÁ ABIERTA!', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'ERROR AL ABRIR LA CAJA!', 'icono' => 'error');
                }
            } else {
                $monto_final = $this->model->getVentas($id_usuario);
                $total_ventas = $this->model->getTotalVentas($id_usuario);
                $inicial = $this->model->getMontoInicial($id_usuario);
                $general = $monto_final['total'] + $inicial['monto_inicial'];
                $data = $this->model->actualizarArqueo($monto_final['total'], $fecha_apertura, $total_ventas['total'], $general, $inicial['id']);
                if ($data == "ok") {
                    $this->model->actualizarApertura($id_usuario);
                    $msg = array('msg' => 'CAJA CERRADA CON ÉXITO!', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'ERROR AL CERRAR LA CAJA!', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function prueba()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $id = $_POST['id'];

        if ($id == ''){
            $datos = $this->model->prueba($id_usuario);
            if (empty($datos)) {
                $mensaje = 'cerrado';
            }else{
                $mensaje = 'abierto';
            }
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listar_arqueo()
    {
        $data = $this->model->getCajas('cierre_caja');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Abierta</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Cerrada</span>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getVentas()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $data['monto_total'] = $this->model->getVentas($id_usuario);
        if ($data['monto_total'] == 'NULL') {
            $data['monto_total'] = 0;
        }
        $data['total_ventas'] = $this->model->getTotalVentas($id_usuario);
        if ($data['total_ventas'] == 'NULL') {
            $data['total_ventas'] = 0;
        }
        $data['inicial'] = $this->model->getMontoInicial($id_usuario);
        $data['monto_general'] = $data['monto_total']['total'] + $data['inicial']['monto_inicial'];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
}
