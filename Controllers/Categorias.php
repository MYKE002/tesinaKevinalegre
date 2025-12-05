<?php

class Categorias extends Controller
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
        $verificar = $this->model->verificarPermisos($id_user, 'categorias');
        if (!empty($verificar) || $id_user == 1) {
            $this->views->getView($this, "index");
        } else {
            header('Location: ' . base_url . 'Errors/permisos');
        }
    }

    public function listar()
    {
        $data = $this->model->getCategorias();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button title = "Editar" class="btn btn-primary" type="button" onclick="btnEditarCat(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                    <button title = "Eliminar" class="btn btn-danger" type="button" onclick="btnEliminarCat(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button class="btn btn-success" type="button" onclick="btnReactivarCat(' . $data[$i]['id'] . ');">Reactivar</button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $nombre = $_POST['nombre'];
        $id = $_POST['id'];

        if (empty($nombre)) {
            $msg = array('msg' => 'CAMPO OBLIGATORIO!', 'icono' => 'warning');
        } else {
            if ($id == "") {
                if (!preg_match("/^.{3,50}$/", $nombre)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else {
                    $data = $this->model->registrarCat($nombre);
                    if ($data == "ok") {
                        $msg = array('msg' => 'CATEGORÍA REGISTRADA CON ÉXITO!', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'LA CATEGORÍA YA EXISTE!', 'icono' => 'warning');
                    } else {
                        $msg = array('msg' => 'ERROR AL REGISTRAR LA CATEGORÍA!', 'icono' => 'error');
                    }
                }
            } else {
                if (!preg_match("/^.{3,50}$/", $nombre)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else {
                    $data = $this->model->modificarCat($nombre, $id);
                    if ($data == "modificado") {
                        $msg = array('msg' => 'CATEGORÍA MODIFICADA CON ÉXITO!', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'ERROR AL MODIFICAR LA CATEGORÍA!', 'icono' => 'error');
                    }
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function editar(int $id)
    {
        $data = $this->model->editarCat($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {
        $data = $this->model->accionCat(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'CATEGORÍA ELIMINADA CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL ELIMINAR LA CATEGORÍA!', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivar(int $id)
    {
        $data = $this->model->accionCat(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'CATEGORÍA REINGRESADA CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL REINGRESAR LA CATEGORÍA!', 'icono' => 'error');
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
