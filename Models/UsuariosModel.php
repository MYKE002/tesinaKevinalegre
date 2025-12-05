<?php
class UsuariosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Método para listar usuarios con JOIN a cajas y roles
    public function getUsuarios()
    {
        $sql = "SELECT 
                u.id,
                u.usuario,
                u.nombre,
                u.telefono,
                u.correo,
                c.caja,
                r.nombre AS rol,
                u.estado
                FROM usuarios u
                INNER JOIN cajas c ON u.id_caja = c.id
                INNER JOIN roles r ON u.id_rol = r.id
                ORDER BY u.id DESC";
        
        $data = $this->selectAll($sql);
        return $data;
    }

    // Obtener usuario para login
    public function getUsuario($usuario, $clave)
    {
        $sql = "SELECT u.*, r.nombre as nombre_rol 
                FROM usuarios u 
                INNER JOIN roles r ON u.id_rol = r.id 
                WHERE u.usuario = '$usuario' AND u.clave = '$clave' AND u.estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    // Método para registrar usuario
    public function registrarUsuario($usuario, $nombre, $clave, $telefono, $correo, $id_caja, $id_rol)
    {
        $sql = "INSERT INTO usuarios (usuario, nombre, clave, telefono, correo, id_caja, id_rol) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $datos = array($usuario, $nombre, $clave, $telefono, $correo, $id_caja, $id_rol);
        $data = $this->save($sql, $datos);
        
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    // Método para modificar usuario
    public function modificarUsuario($usuario, $nombre, $telefono, $correo, $id_caja, $id_rol, $id)
    {
        $sql = "UPDATE usuarios 
                SET usuario = ?, nombre = ?, telefono = ?, correo = ?, id_caja = ?, id_rol = ? 
                WHERE id = ?";
        
        $datos = array($usuario, $nombre, $telefono, $correo, $id_caja, $id_rol, $id);
        $data = $this->save($sql, $datos);
        
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    // Método para editar usuario (obtener datos)
    public function editarUser($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    // Método para cambiar estado
    public function accionUser($estado, $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    // Verificar si el usuario existe
    public function verificarUsuario($usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $data = $this->select($sql);
        return $data;
    }

    // Modificar contraseña
    public function modificarPass($clave, $id)
    {
        $sql = "UPDATE usuarios SET clave = ? WHERE id = ?";
        $datos = array($clave, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    // Obtener cajas
    public function getCajas()
    {
        $sql = "SELECT * FROM cajas WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    // Obtener roles
    public function getRoles()
    {
        $sql = "SELECT * FROM roles ORDER BY nombre ASC";
        $data = $this->selectAll($sql);
        return $data;
    }
}
?>