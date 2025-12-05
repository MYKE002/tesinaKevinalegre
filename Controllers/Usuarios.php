<?php
class Usuarios extends Controller
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
        $data['cajas'] = $this->model->getCajas();
        $data['roles'] = $this->model->getRoles();
        $this->views->getView($this, "index", $data);
    }

    // Validar login
    public function validar()
    {
        if (isset($_POST['usuario']) && isset($_POST['clave'])) {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            
            if (empty($usuario) || empty($clave)) {
                $msg = "LOS CAMPOS ESTÁN VACÍOS";
            } else {
                $hash = hash("SHA1", $clave);
                $data = $this->model->getUsuario($usuario, $hash);
                
                if ($data) {
                    $_SESSION['id_usuario'] = $data['id'];
                    $_SESSION['usuario'] = $data['usuario'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $_SESSION['correo'] = $data['correo'];
                    $_SESSION['activo'] = true;
                    $msg = "ok";
                } else {
                    $msg = "USUARIO O CONTRASEÑA INCORRECTA";
                }
            }
        } else {
            $msg = "ERROR EN LA PETICIÓN";
        }
        
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para listar usuarios (usado por DataTables)
    public function listar()
    {
        try {
            $data = $this->model->getUsuarios();
            
            // Procesar los datos para el DataTable
            for ($i = 0; $i < count($data); $i++) {
                
                // Estado con badge
                if ($data[$i]['estado'] == 1) {
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                    $data[$i]['acciones'] = '<div>
                        <button class="btn btn-primary" type="button" onclick="btnEditarUser(' . $data[$i]['id'] . ');" title="Editar"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger" type="button" onclick="btnEliminarUser(' . $data[$i]['id'] . ');" title="Desactivar"><i class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-warning" type="button" onclick="btnReingresarPass(' . $data[$i]['id'] . ');" title="Cambiar Contraseña"><i class="fas fa-key"></i></button>
                    </div>';
                } else {
                    $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                    $data[$i]['acciones'] = '<div>
                        <button class="btn btn-success" type="button" onclick="btnReingresarUser(' . $data[$i]['id'] . ');" title="Activar"><i class="fas fa-check"></i></button>
                    </div>';
                }
            }
            
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
            
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    // Registrar o modificar usuario
    public function registrar()
    {
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];
        $confirmar = $_POST['confirmar'];
        $id_caja = $_POST['caja'];
        $id_rol = $_POST['rol'];
        $id = $_POST['id'];

        // Validaciones básicas
        if (empty($usuario) || empty($nombre) || empty($telefono) || empty($correo) || empty($id_caja) || empty($id_rol)) {
            $msg = array('msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS', 'icono' => 'warning');
        } else {
            
            if ($id == "") {
                // Registrar nuevo usuario
                
                if (empty($clave) || empty($confirmar)) {
                    $msg = array('msg' => 'LA CONTRASEÑA ES OBLIGATORIA', 'icono' => 'warning');
                } else if ($clave != $confirmar) {
                    $msg = array('msg' => 'LAS CONTRASEÑAS NO COINCIDEN', 'icono' => 'warning');
                } else {
                    // Verificar si el usuario ya existe
                    $verificar = $this->model->verificarUsuario($usuario);
                    
                    if (empty($verificar)) {
                        $hash = hash("SHA1", $clave);
                        $data = $this->model->registrarUsuario($usuario, $nombre, $hash, $telefono, $correo, $id_caja, $id_rol);
                        
                        if ($data == "ok") {
                            $msg = array('msg' => 'USUARIO REGISTRADO CORRECTAMENTE', 'icono' => 'success');
                        } else {
                            $msg = array('msg' => 'ERROR AL REGISTRAR EL USUARIO', 'icono' => 'error');
                        }
                    } else {
                        $msg = array('msg' => 'EL USUARIO YA EXISTE', 'icono' => 'warning');
                    }
                }
                
            } else {
                // Modificar usuario existente
                $data = $this->model->modificarUsuario($usuario, $nombre, $telefono, $correo, $id_caja, $id_rol, $id);
                
                if ($data == "modificado") {
                    $msg = array('msg' => 'USUARIO MODIFICADO CORRECTAMENTE', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'ERROR AL MODIFICAR EL USUARIO', 'icono' => 'error');
                }
            }
        }
        
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Editar usuario (obtener datos)
    public function editar(int $id)
    {
        $data = $this->model->editarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Eliminar (desactivar) usuario
    public function eliminar(int $id)
    {
        $data = $this->model->accionUser(0, $id);
        
        if ($data == 1) {
            $msg = array('msg' => 'USUARIO DESACTIVADO', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL DESACTIVAR EL USUARIO', 'icono' => 'error');
        }
        
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Reingresar (activar) usuario
    public function reingresar(int $id)
    {
        $data = $this->model->accionUser(1, $id);
        
        if ($data == 1) {
            $msg = array('msg' => 'USUARIO ACTIVADO', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'ERROR AL ACTIVAR EL USUARIO', 'icono' => 'error');
        }
        
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Cambiar contraseña
    public function cambiarPass()
    {
        $actual = $_POST['clave_actual'];
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['confirmar_clave'];
        
        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $msg = array('msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS', 'icono' => 'warning');
        } else {
            
            if ($nueva != $confirmar) {
                $msg = array('msg' => 'LAS CONTRASEÑAS NO COINCIDEN', 'icono' => 'warning');
            } else {
                $id = $_SESSION['id_usuario'];
                $hash = hash("SHA1", $actual);
                $data = $this->model->editarUser($id);
                
                if ($hash == $data['clave']) {
                    $verificar = $this->model->modificarPass(hash("SHA1", $nueva), $id);
                    
                    if ($verificar == 1) {
                        $msg = array('msg' => 'CONTRASEÑA MODIFICADA', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'ERROR AL MODIFICAR LA CONTRASEÑA', 'icono' => 'error');
                    }
                } else {
                    $msg = array('msg' => 'LA CONTRASEÑA ACTUAL NO COINCIDE', 'icono' => 'warning');
                }
            }
        }
        
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Cerrar sesión
    public function salir()
    {
        session_start();
        session_destroy();
        header("location: " . base_url);
        exit();
    }
}
?>