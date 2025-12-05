<?php

class Productos extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_user = $_SESSION['id_usuario'];
        $verificar = $this->model->verificarPermisos($id_user, 'productos');
        if (!empty($verificar) || $id_user == 1) {
            $data['categorias'] = $this->model->getCategorias();
            $this->views->getView($this, "index", $data);
        } else {
            header('Location: ' . base_url . 'Errors/permisos');
        }
    }

    public function listar()
    {

        $data = $this->model->getProductos();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class = "img-thumbnail" src = "' . base_url . "Assets/img/" . $data[$i]['foto'] . '" width = "100">';
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button title = "Editar" class="btn btn-primary" type="button" onclick="btnEditarPro(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                    <button title = "Eliminar" class="btn btn-danger" type="button" onclick="btnEliminarPro(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '
                <div>
                    <button class="btn btn-success" type="button" onclick="btnReactivarPro(' . $data[$i]['id'] . ');">Reactivar</button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function registrar()
    {
        $codigo = $_POST['codigoP'];
        $nombre = $_POST['nombreP'];
        $precio_compra = $_POST['precio_compraP'];
        $precio_venta = $_POST['precio_ventaP'];
        $categoria = $_POST['categoria'];
        $id = $_POST['idP'];
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $fecha = date("YmdHis");

        if (empty($codigo) || empty($nombre) || empty($precio_compra) || empty($precio_venta)) {
            $msg = "TODOS LOS CAMPOS SON OBLIGATORIOS";
        } else {
            if (!empty($name)) {
                $imgNombre = $fecha . ".jpg";
                $destino = "Assets/img/" .  $imgNombre;
            } elseif (!empty($_POST['foto-actual']) && empty($name)) {
                $imgNombre = $_POST['foto-actual'];
            } else {
                $imgNombre = 'default.png';
            }
            if ($id == "") {
                if (!preg_match("/^[a-zA-Z0-9]{1,20}$/", $codigo)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else if (!preg_match("/^.{3,150}$/", $nombre)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else if (!preg_match("/^[0-9]{1,10}$/", $precio_compra)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else if (!preg_match("/^[0-9]{1,10}$/", $precio_venta)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else {
                    $data = $this->model->registrarProducto($codigo, $nombre, $precio_compra, $precio_venta, $categoria, $imgNombre);
                    if ($data == "ok") {
                        $msg = array('msg' => 'PRODUCTO REGISTRADO CON ÉXITO!', 'icono' => 'success');
                        if (!empty($name)) {
                            move_uploaded_file($tmpname, $destino);
                        }
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'EL PRODUCTO YA EXISTE!', 'icono' => 'warning');
                    } else {
                        $msg = array('msg' => 'ERROR AL REGISTRAR EL PRODUCTO!', 'icono' => 'error');
                    }
                }
            } else {
                if (!preg_match("/^[a-zA-Z0-9]{1,20}$/", $codigo)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else if (!preg_match("/^.{3,150}$/", $nombre)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else if (!preg_match("/^[0-9]{1,10}$/", $precio_compra)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else if (!preg_match("/^[0-9]{1,10}$/", $precio_venta)) {
                    $msg = array('msg' => 'NO CUMPLE CON LOS PARÁMETROS REQUERIDOS!', 'icono' => 'error');
                } else {
                    $imgDelete = $this->model->editarPro($id);
                    if ($imgDelete['foto'] != 'default.png') {
                        if (file_exists("Assets/img/" . $imgDelete['foto'])) {
                            unlink("Assets/img/" . $imgDelete['foto']);
                        }
                    }
                    $data = $this->model->modificarProducto($codigo, $nombre, $precio_compra, $precio_venta, $categoria, $imgNombre, $id);
                    if ($data == "modificado") {
                        if (!empty($name)) {
                            move_uploaded_file($tmpname, $destino);
                        }
                        $msg = array('msg' => 'PRODUCTO MODIFICADO CON ÉXITO!', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'ERROR AL MODIFICAR EL PRODUCTO!', 'icono' => 'error');
                    }
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function editar(int $id)
    {
        $data = $this->model->editarPro($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {
        $data = $this->model->accionPro(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'PRODUCTO ELIMINADO CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL ELIMINAR EL PRODUCTO!', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivar(int $id)
    {
        $data = $this->model->accionPro(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'PRODUCTO REINGRESADO CON ÉXITO!', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL REINGRESAR EL PRODUCTO!', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
