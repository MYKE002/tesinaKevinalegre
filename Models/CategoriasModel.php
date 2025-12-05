<?php
class CategoriasModel extends Query
{
    private $nombre, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }

    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarCat(string $nombre)
    {
        $this->nombre = $nombre;
        $verificar = "SELECT * FROM categorias WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO  categorias(nombre) VALUES (?)";
            $datos = array($this->nombre);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";

                date_default_timezone_set('America/Asuncion');
                $id_usuario = $_SESSION['id_usuario'];
                $fecha_hora = date('Y-m-d H:i:s');
                $movimiento = "Nueva Categoria: '" . $nombre . "', agregada";
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

    public function editarCat(int $id)
    {
        $sql = "SELECT * FROM categorias WHERE id = $id";
        $data = $this->select($sql);

        return $data;
    }

    public function modificarCat(string $nombre, int $id)
    {
        $this->nombre = $nombre;
        $this->id = $id;

        $sql = "UPDATE categorias SET nombre = ? WHERE id = ?";
        $datos = array($this->nombre, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Categoria: '". $nombre . "' con ID: " . $id . ", modificada";
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

    public function accionCat(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;

        if ($estado == 0) {
            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Categoria con ID: " . $id . ", eliminada";
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
            $movimiento = "Categoria con ID: " . $id . ", reingresada";
            $mysqli = new mysqli('localhost', 'root', '', 'sistema');
            $query3 = 'INSERT INTO auditoria (id_usuario, fecha_hora, movimiento) VALUES (?, ?, ?)';

            // "Preparing" the query using mysqli->prepare(query) -- which is the equivalent of mysql_real_escape_string -- in other words, it's the SAFE database injection method
            $stmt = $mysqli->prepare($query3);

            // "Bind_param" == replace all the "?"'s in the aforementioned query with the variables below

            $stmt->bind_param("sss", $id_usuario, $fecha_hora, $movimiento);

            // Perform the actual query!
            $stmt->execute();
        }

        $sql = "UPDATE categorias SET estado = ? WHERE id = ?";
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
