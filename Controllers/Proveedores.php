<?php

class Proveedores extends Controller
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
        $verificar = $this->model->verificarPermisos($id_user, 'proveedores');
        if (!empty($verificar) || $id_user == 1) {
            $this->views->getView($this, "index");
        } else {
            header('Location: ' . base_url . 'Errors/permisos');
        }
    }

    public function listar()
    {
        $data = $this->model->getProveedores();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button title = "Editar" class="btn btn-primary" type="button" onclick="btnEditarProv(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                    <button title = "Eliminar" class="btn btn-danger" type="button" onclick="btnEliminarProv(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button class="btn btn-success" type="button" onclick="btnReactivarProv(' . $data[$i]['id'] . ');">Reactivar</button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermisos($id_user, 'registrar_proveedor');
        if (!empty($verificar) || $id_user == 1) {
            $ruc = $_POST['ruc'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];
            $id = $_POST['id'];

            if (empty($ruc) || empty($nombre) || empty($telefono) || empty($direccion)) {
                $msg = "TODOS LOS CAMPOS SON OBLIGATORIOS";
            } else {
                if ($id == "") {
                    if (!preg_match("/^[0-9a-zA-Z- ]{5,20}$/", $ruc)) {
                        $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                    } else if (!preg_match("/^[a-zA-ZÀ-ÿ ]{3,100}$/", $nombre)) {
                        $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                    } else if (!preg_match("/^[0-9-+() ]{10,30}$/", $telefono)) {
                        $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                    } else if (!preg_match("/^.{5,200}$/", $direccion)) {
                        $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                    } else if (!empty($correo)) {
                        if (!preg_match("/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/", $correo)) {
                            $msg = array('msg' => 'INGRESE UN CORREO VÁLIDO!', 'icono' => 'warning');
                        } else {
                            $data = $this->model->registrarProveedor($ruc, $nombre, $telefono, $correo, $direccion);
                            if ($data == "ok") {
                                $msg = array('msg' => 'PROVEEDOR REGISTRADO CON ÉXITO!', 'icono' => 'success');
                            } else if ($data == "existe") {
                                $msg = array('msg' => 'EXISTE UN PROVEEDOR REGISTRADO CON LA MISMA CÉDULA!', 'icono' => 'warning');
                            } else {
                                $msg = array('msg' => 'ERROR AL REGISTRAR EL PROVEEDOR!', 'icono' => 'error');
                            }
                        }
                    } else {
                        $data = $this->model->registrarProveedor($ruc, $nombre, $telefono, $correo, $direccion);
                        if ($data == "ok") {
                            $msg = array('msg' => 'PROVEEDOR REGISTRADO CON ÉXITO!', 'icono' => 'success');
                        } else if ($data == "existe") {
                            $msg = array('msg' => 'EXISTE UN PROVEEDOR REGISTRADO CON LA MISMA CÉDULA!', 'icono' => 'warning');
                        } else {
                            $msg = array('msg' => 'ERROR AL REGISTRAR EL PROVEEDOR!', 'icono' => 'error');
                        }
                    }
                } else {
                    if (!preg_match("/^[0-9a-zA-Z- ]{5,20}$/", $ruc)) {
                        $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                    } else if (!preg_match("/^[a-zA-ZÀ-ÿ ]{3,100}$/", $nombre)) {
                        $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                    } else if (!preg_match("/^[0-9-+() ]{10,16}$/", $telefono)) {
                        $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                    } else if (!preg_match("/^.{5,200}$/", $direccion)) {
                        $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                    } else if (!empty($correo)) {
                        if (!preg_match("/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/", $correo)) {
                            $msg = array('msg' => 'INGRESE UN CORREO VÁLIDO!', 'icono' => 'warning');
                        } else {
                            $data = $this->model->modificarPROVEEDOR($ruc, $nombre, $telefono, $correo, $direccion, $id);
                            if ($data == "modificado") {
                                $msg = array('msg' => 'PROVEEDOR MODIFICADO CON ÉXITO!', 'icono' => 'success');
                            } else {
                                $msg = array('msg' => 'ERROR AL MODIFICAR EL PROVEEDOR!', 'icono' => 'error');
                            }
                        }
                    } else {
                        $data = $this->model->modificarPROVEEDOR($ruc, $nombre, $telefono, $correo, $direccion, $id);
                        if ($data == "modificado") {
                            $msg = array('msg' => 'PROVEEDOR MODIFICADO CON ÉXITO!', 'icono' => 'success');
                        } else {
                            $msg = array('msg' => 'ERROR AL MODIFICAR EL PROVEEDOR!', 'icono' => 'error');
                        }
                    }

                }
            }
        } else {
            $msg = array('msg' => 'NO TIENES PERMISO PARA REGISTRAR NI EDITAR PROVEEDORES!', 'icono' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->editarPro($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermisos($id_user, 'eliminar_Proveedors');
        if (!empty($verificar) || $id_user == 1) {
            $data = $this->model->accionPro(0, $id);
            if ($data == 1) {
                $msg = array('msg' => 'Proveedor ELIMINADO CON ÉXITO!', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'ERROR AL ELIMINAR EL Proveedor!', 'icono' => 'error');
            }
        } else {
            $msg = array('msg' => 'NO TIENES PERMISO PARA ELIMINAR ProveedorS!', 'icono' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivar(int $id)
    {
        $data = $this->model->accionPro(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'PROVEEDOR REINGRESADO CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL REINGRESAR EL Proveedor!', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
}
