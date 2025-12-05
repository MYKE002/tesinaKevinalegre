<?php
class ComprasModel extends Query
{
    private $codigo, $nombre, $precio_compra, $precio_venta, $id_categoria, $id, $estado, $img;

    public function __construct()
    {
        parent::__construct();
    }

    public function getClientes()
    {
        $sql = "SELECT * FROM clientes WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getProveedores()
    {
        $sql = "SELECT * FROM proveedores WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getProCod(string $cod)
    {
        $sql = "SELECT * FROM productos WHERE codigo = '$cod'";
        $data = $this->select($sql);
        return $data;
    }

    public function getProductos(int $id)
    {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function registrarDetalle(string $table, int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
    {
        $sql = "INSERT INTO $table(id_producto, id_usuario, precio, cantidad, sub_total) VALUES (?, ?, ?, ?, ?)";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getDetalle(string $table, int $id)
    {
        $sql = "SELECT d.*, p.id AS id_pro, p.descripcion FROM $table d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function calcularCompra(string $table, int $id_usuario)
    {
        $sql = "SELECT sub_total, SUM(sub_total) AS total FROM $table WHERE id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data;
    }

    public function deleteDetalle(string $table, int $id)
    {
        $sql = "DELETE FROM $table WHERE id = ?";
        $datos = array($id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function consultarDetalle(string $table, int $id_producto, int $id_usuario)
    {
        $sql = "SELECT * FROM $table detalles WHERE id_producto = $id_producto AND $id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data;
    }

    public function actualizarDetalle(string $table, string $precio, int $cantidad, string $sub_total, int $id_producto, int $id_usuario)
    {
        $sql = "UPDATE $table SET precio = ?, cantidad = ?, sub_total = ? WHERE id_producto = ? AND id_usuario = ?";
        $datos = array($precio, $cantidad, $sub_total, $id_producto, $id_usuario);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function registrarCompra( string $total, int $id_proveedor, int $id_user)
    {
        
        $sql = "INSERT INTO compras (total, id_proveedor, id_usuario) VALUES (?, ?, ?)";
        $datos = array($total, $id_proveedor, $id_user);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Compra Realizada por un total de: " . $total . " Gs.";
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




    public function getId(string $table)
    {
        $sql = "SELECT MAX(id) AS id FROM $table";
        $data = $this->select($sql);
        return $data;
    }

    public function registrarDetalleCompra(int $id_compra, int $id_pro, int $cantidad, int $precio, string $sub_total)
    {
        $sql = "INSERT INTO detalle_compras (id_compra, id_producto, cantidad, precio, sub_total) VALUES (?, ?, ?, ?, ?)";
        $datos = array($id_compra, $id_pro, $cantidad, $precio, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }


    public function registrarDetalleVenta(int $id_venta, int $id_pro, int $cantidad, string $desc, int $precio, string $sub_total)
    {
        $sql = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, descuento, precio, sub_total) VALUES (?, ?, ?, ?, ?, ?)";
        $datos = array($id_venta, $id_pro, $cantidad, $desc, $precio, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }


    public function getEmpresa()
    {
        $sql = "SELECT * FROM empresa";
        $data = $this->select($sql);
        return ($data);
    }

    public function vaciarDetalle(string $table, int $id_usuario)
    {
        $sql = "DELETE FROM $table WHERE id_usuario = ?";
        $datos = array($id_usuario);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getProCompra(int $id_compra)
    {
        $sql = "SELECT c.*, d.*, p.id, p.descripcion FROM compras c INNER JOIN detalle_compras d 
        ON c.id = d.id_compra INNER JOIN productos p ON p.id = d.id_producto WHERE c.id = $id_compra";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getVenta(int $id_venta)
    {
        $sql = "SELECT DATE_FORMAT(fecha, '%d/%m/%Y') as fecha FROM ventas WHERE id = $id_venta";
        $data = $this->select($sql);
        return $data;
    }

    public function getProVenta(int $id_venta)
    {
        $sql = "SELECT v.*, d.*, p.id, p.descripcion FROM ventas v INNER JOIN detalle_ventas d 
        ON v.id = d.id_venta INNER JOIN productos p ON p.id = d.id_producto WHERE v.id = $id_venta";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getHistorialCompras()
    {
        $sql = "SELECT p.*, p.nombre as proveedor, c.* FROM proveedores p INNER JOIN compras c ON c.id_proveedor = p.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getHistorialVentas()
    {
        $sql = "SELECT c.*, c.nombre, v.* FROM clientes c INNER JOIN ventas v ON v.id_cliente = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function actualizarStock(int $cantidad, int $id_pro)
    {
        $sql = "UPDATE productos SET cantidad = ? WHERE id = ?";
        $datos = array($cantidad, $id_pro);
        $data = $this->save($sql, $datos);

        return $data;
    }

    public function registrarVenta(int $id_user, int $id_cliente, string $total)
    {
        $sql = "INSERT INTO ventas (id_usuario, id_cliente, total) VALUES (?, ?, ?)";
        $datos = array($id_user, $id_cliente, $total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";

            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Venta Realizada por un total de: " . $total . " Gs. al cliente con ID: ". $id_cliente;
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

    public function clientesVenta(int $id)
    {
        $sql = "SELECT v.id, v.id_cliente, c.* FROM ventas v INNER JOIN clientes c ON c.id = v.id_cliente WHERE v.id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function proveedoresCompra(int $id)
    {
        $sql = "SELECT u.usuario, u.nombre as comprador, c.id, c.id_proveedor, p.* FROM compras c INNER JOIN proveedores p ON p.id = c.id_proveedor INNER JOIN usuarios u on u.id = c.id_usuario WHERE c.id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function verificarDesc(int $id)
    {
        $sql = "SELECT * FROM detalle_temp WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function actualizarDescuento(string $desc, string $sub_total, string $id)
    {
        $sql = "UPDATE detalle_temp SET descuento = ?, sub_total = ? WHERE id = ?";
        $datos = array($desc, $sub_total, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getDescuento(int $id_venta)
    {
        $sql = "SELECT descuento, SUM(descuento) AS total FROM detalle_ventas WHERE id_venta = $id_venta";
        $data = $this->select($sql);
        return $data;
    }

    public function getAnularCompra(int $id_compra)
    {
        $sql = "SELECT c.*, d.* FROM compras c INNER JOIN detalle_compras d 
        ON c.id = d.id_compra WHERE c.id = $id_compra";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getAnular(int $id_compra)
    {
        $sql = "UPDATE compras SET estado = ? WHERE id = ?";
        $datos = array(0, $id_compra);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";

            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Compra con ID: " . $id_compra . ", anulada.";
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

    public function getAnularVenta(int $id_venta)
    {
        $sql = "SELECT v.*, d.* FROM ventas v INNER JOIN detalle_ventas d 
        ON v.id = d.id_venta WHERE v.id = $id_venta";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getAnularV(int $id_venta)
    {
        $sql = "UPDATE ventas SET estado = ? WHERE id = ?";
        $datos = array(0, $id_venta);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";

            date_default_timezone_set('America/Asuncion');
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_hora = date('Y-m-d H:i:s');
            $movimiento = "Venta con ID: " . $id_venta . ", anulada.";
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

    public function verificarCaja(int $id)
    {
        $sql = "SELECT * FROM cierre_caja WHERE id_usuario = $id AND ESTADO = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function verificarPermisos(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }

    //PARA REGISTRAR NUEVO PRODUCTO EN COMPRAS
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        $datos = $this->selectAll($sql);
        return $datos;
    }
}
