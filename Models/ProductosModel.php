<?php
class ProductosModel extends Query
{
    private $codigo, $nombre, $precio_compra, $precio_venta, $id_categoria, $id, $estado, $img;
    public function __construct()
    {
        parent::__construct();
    }

    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getProductos()
    {
        $sql = "SELECT p.*, c.id AS id_cat, c.nombre AS categoria FROM productos p INNER JOIN categorias c ON p.id_categoria = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, int $id_categoria, string $img)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->id_categoria = $id_categoria;
        $this->img = $img;
        $verificar = "SELECT * FROM productos WHERE codigo = '$this->codigo'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO productos(codigo, descripcion, precio_compra, precio_venta, id_categoria, foto) VALUES (?, ?, ?, ?, ?,?)";
            $datos = array($this->codigo, $this->nombre, $this->precio_compra, $this->precio_venta, $this->id_categoria, $this->img);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";

                date_default_timezone_set('America/Asuncion');
                $id_usuario = $_SESSION['id_usuario'];
                $fecha_hora = date('Y-m-d H:i:s');
                $movimiento = "Nuevo Producto: '" . $nombre . "' con código: ". $codigo. ", ingresado";
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
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select($sql);

        return $data;
    }

    public function modificarProducto(string $codigo, string $nombre, string $precio_compra, string $precio_venta, int $id_categoria, string $img,  int $id)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->id_categoria = $id_categoria;
        $this->img = $img;
        $this->id = $id;

        $sql = "UPDATE productos SET codigo = ?, descripcion = ?, precio_compra = ?, precio_venta = ?, id_categoria = ?, foto = ? WHERE id = ?";
        $datos = array($this->codigo, $this->nombre, $this->precio_compra, $this->precio_venta, $this->id_categoria,  $this->img, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";

            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Producto: '" . $nombre . "' y código: ". $codigo. ", modificado";
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
            $movimiento = "Producto con ID: " . $id . ", eliminado";
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
            $movimiento = "Producto con ID: " . $id . ", reingresado";
            $mysqli = new mysqli('localhost', 'root', '', 'sistema');
            $query3 = 'INSERT INTO auditoria (id_usuario, fecha_hora, movimiento) VALUES (?, ?, ?)';

            // "Preparing" the query using mysqli->prepare(query) -- which is the equivalent of mysql_real_escape_string -- in other words, it's the SAFE database injection method
            $stmt = $mysqli->prepare($query3);

            // "Bind_param" == replace all the "?"'s in the aforementioned query with the variables below

            $stmt->bind_param("sss", $id_usuario, $fecha_hora, $movimiento);

            // Perform the actual query!
            $stmt->execute();
        }

        $sql = "UPDATE productos SET estado = ? WHERE id = ?";
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
