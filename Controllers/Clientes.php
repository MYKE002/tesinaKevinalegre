<?php

class Clientes extends Controller
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
        $this->views->getView($this, "index");
    }

    public function listar()
    {
        $data = $this->model->getClientes();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button title = "Editar" class="btn btn-primary" type="button" onclick="btnEditarCli(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                    <button title = "Eliminar" class="btn btn-danger" type="button" onclick="btnEliminarCli(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button class="btn btn-success" type="button" onclick="btnReactivarCli(' . $data[$i]['id'] . ');">Reactivar</button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {

            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];
            $id = $_POST['id'];

            if (empty($cedula) || empty($nombre) || empty($telefono) || empty($direccion)) {
                $msg = "TODOS LOS CAMPOS SON OBLIGATORIOS";
            } else {
                if ($id == "") {
                    if (!preg_match("/^[0-9a-zA-Z- ]{5,20}$/", $cedula)) {
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
                            $data = $this->model->registrarCliente($cedula, $nombre, $telefono, $correo, $direccion);
                            if ($data == "ok") {
                                $msg = array('msg' => 'CLIENTE REGISTRADO CON ÉXITO!', 'icono' => 'success');
                            } else if ($data == "existe") {
                                $msg = array('msg' => 'EXISTE UN CLIENTE REGISTRADO CON LA MISMA CÉDULA!', 'icono' => 'warning');
                            } else {
                                $msg = array('msg' => 'ERROR AL REGISTRAR EL CLIENTE!', 'icono' => 'error');
                            }
                        }
                    } else {
                        $data = $this->model->registrarCliente($cedula, $nombre, $telefono, $correo, $direccion);
                        if ($data == "ok") {
                            $msg = array('msg' => 'CLIENTE REGISTRADO CON ÉXITO!', 'icono' => 'success');
                        } else if ($data == "existe") {
                            $msg = array('msg' => 'EXISTE UN CLIENTE REGISTRADO CON LA MISMA CÉDULA!', 'icono' => 'warning');
                        } else {
                            $msg = array('msg' => 'ERROR AL REGISTRAR EL CLIENTE!', 'icono' => 'error');
                        }
                    }
                } else {
                    if (!preg_match("/^[0-9a-zA-Z- ]{5,20}$/", $cedula)) {
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
                            $data = $this->model->modificarCliente($cedula, $nombre, $telefono, $correo, $direccion, $id);
                            if ($data == "modificado") {
                                $msg = array('msg' => 'CLIENTE MODIFICADO CON ÉXITO!', 'icono' => 'success');
                            } else {
                                $msg = array('msg' => 'ERROR AL MODIFICAR EL CLIENTE!', 'icono' => 'error');
                            }
                        }
                    } else {
                        $data = $this->model->modificarCliente($cedula, $nombre, $telefono, $correo, $direccion, $id);
                        if ($data == "modificado") {
                            $msg = array('msg' => 'CLIENTE MODIFICADO CON ÉXITO!', 'icono' => 'success');
                        } else {
                            $msg = array('msg' => 'ERROR AL MODIFICAR EL CLIENTE!', 'icono' => 'error');
                        }
                    }

                }
            }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->editarCli($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {
            $data = $this->model->accionCli(0, $id);
            if ($data == 1) {
                $msg = array('msg' => 'CLIENTE ELIMINADO CON ÉXITO!', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'ERROR AL ELIMINAR EL CLIENTE!', 'icono' => 'error');
            }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivar(int $id)
    {
        $data = $this->model->accionCli(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'CLIENTE REINGRESADO CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL REINGRESAR EL CLIENTE!', 'icono' => 'error');
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
