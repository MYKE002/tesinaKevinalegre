<?php
class ProveedoresModel extends Query
{
    private $ruc, $nombre, $telefono, $correo, $direccion, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }

    public function getProveedores()
    {
        $sql = "SELECT * FROM proveedores";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarProveedor(string $ruc, string $nombre, string $telefono, string $correo, string $direccion)
    {
        $this->ruc = $ruc;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->direccion = $direccion;

        $verificar = "SELECT * FROM proveedores WHERE ruc = '$this->ruc'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO  proveedores(ruc, nombre, telefono, correo, direccion) VALUES (?, ?, ?, ?, ?)";
            $datos = array($this->ruc, $this->nombre, $this->telefono, $this->correo, $this->direccion);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";

                date_default_timezone_set('America/Asuncion');
                $id_usuario = $_SESSION['id_usuario'];
                $fecha_hora = date('Y-m-d H:i:s');
                $movimiento = "Nuevo Proveedor con RUC: '" . $ruc . "', ingresado";
                $mysqli = new mysqli('localhost', 'root', '', 'sistema');
                $query3 = 'INSERT INTO auditoria (id_usuario, fecha_hora, movimiento) VALUES (?, ?, ?)';

                // "Preparing" the query using mysqli->prepare(query) -- which is the equivalent of mysql_real_escape_string -- in other words, it's the SAFE database injection method
                $stmt = $mysqli->prepare($query3);

                // "Bind_param" == replace all the "?"'s in the aforementioned query with the variables below
                $stmt->bind_param("sss", $id_usuario, $fecha_hora, $movimiento);

                // Perform the actual query!
                $stmt->execute();
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }

        return $res;
    }

    public function editarPro(int $id)
    {
        $sql = "SELECT * FROM proveedores WHERE id = $id";
        $data = $this->select($sql);

        return $data;
    }

    public function modificarProveedor(string $ruc, string $nombre, string $telefono, string $correo, string $direccion, int $id)
    {
        $this->ruc = $ruc;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->id = $id;

        $sql = "UPDATE proveedores SET ruc = ?, nombre = ?, telefono = ?, correo = ? , direccion = ? WHERE id = ?";
        $datos = array($this->ruc, $this->nombre, $this->telefono, $this->correo, $this->direccion, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";

            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Proveedor con RUC: '" . $ruc . "' y ID: '" . $id . "', modificado";
            $mysqli = new mysqli('localhost', 'root', '', 'sistema');
            $query3 = 'INSERT INTO auditoria (id_usuario, fecha_hora, movimiento) VALUES (?, ?, ?)';
    
            // "Preparing" the query using mysqli->prepare(query) -- which is the equivalent of mysql_real_escape_string -- in other words, it's the SAFE database injection method
            $stmt = $mysqli->prepare($query3);
    
            // "Bind_param" == replace all the "?"'s in the aforementioned query with the variables below
            $stmt->bind_param("sss", $id_usuario, $fecha_hora, $movimiento);
    
            // Perform the actual query!
            $stmt->execute();

        } else {
            $res = "error";
        }
        return $res;
    }

    public function accionPro(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;

        if ($estado == 0) {
            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Cliente con ID: '" . $id . "', eliminado";
            $mysqli = new mysqli('localhost', 'root', '', 'sistema');
            $query3 = 'INSERT INTO auditoria (id_usuario, fecha_hora, movimiento) VALUES (?, ?, ?)';

            // "Preparing" the query using mysqli->prepare(query) -- which is the equivalent of mysql_real_escape_string -- in other words, it's the SAFE database injection method
            $stmt = $mysqli->prepare($query3);

            // "Bind_param" == replace all the "?"'s in the aforementioned query with the variables below

            $stmt->bind_param("sss", $id_usuario, $fecha_hora, $movimiento);

            // Perform the actual query!
            $stmt->execute();
        } else {
            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Proveedor con ID: '" . $id . "', reingresado";
            $mysqli = new mysqli('localhost', 'root', '', 'sistema');
            $query3 = 'INSERT INTO auditoria (id_usuario, fecha_hora, movimiento) VALUES (?, ?, ?)';

            // "Preparing" the query using mysqli->prepare(query) -- which is the equivalent of mysql_real_escape_string -- in other words, it's the SAFE database injection method
            $stmt = $mysqli->prepare($query3);

            // "Bind_param" == replace all the "?"'s in the aforementioned query with the variables below

            $stmt->bind_param("sss", $id_usuario, $fecha_hora, $movimiento);

            // Perform the actual query!
            $stmt->execute();
        }

        $sql = "UPDATE proveedores SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function verificarPermisos(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
