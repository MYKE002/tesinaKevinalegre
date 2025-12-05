<?php
class AdministracionModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM empresa";
        $data = $this->select($sql);
        return $data;
    }
    
    public function getFactura()
    {
        $sql = "SELECT * FROM detalle_facturas";
        $data = $this->select($sql);
        return $data;
    }


    public function getAuditoria()
    {
        $sql = "SELECT a.id AS id, a.fecha_hora AS fecha, a.movimiento as movimiento, u.usuario AS usuario FROM usuarios u INNER JOIN auditoria a ON u.id = a.id_usuario";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function modificar(string $nombre, string $telefono, string $ruc, string $direccion, string $mensaje, int $id)
    {

        $sql = "UPDATE empresa SET nombre = ?, telefono = ?, ruc = ?, direccion = ?, mensaje = ? WHERE id = ?";
        $datos = array($nombre, $telefono, $ruc, $direccion, $mensaje, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function modificarfactura(string $timbrado, string $inicio_venta, string $fin_venta, string $suc_caja, string $numero_factura, string $condicion, int $iva, int $id)
    {

        $sql = "UPDATE detalle_facturas SET timbrado = ?, inicio_venta = ?, fin_venta = ?, suc_caja = ?, numero_factura = ?, condicion = ?, iva = ? WHERE id = ?";
        $datos = array($timbrado, $inicio_venta, $fin_venta, $suc_caja, $numero_factura, $condicion, $iva, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
 
    public function getDatos(string $table)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table";
        $data = $this->select($sql);
        return $data;
    }

    public function getVentas()
    {
        $sql = "SELECT COUNT(*) AS total FROM ventas WHERE fecha > CURDATE()";
        $data = $this->select($sql);
        return $data;
    }

    public function getStockMinimo()
    {
        $sql = "SELECT * FROM productos WHERE estado = 1 AND cantidad < 15 ORDER BY cantidad DESC LIMIT  10";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getProdVend()
    {
        $sql = "SELECT d.id_producto, d.cantidad, p.id, p.descripcion, SUM(d.cantidad) AS total 
        FROM detalle_ventas d INNER JOIN productos p ON p.id = d.id_producto GROUP BY d.id_producto ORDER BY d.cantidad DESC LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
 
    public function verificarPermisos(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
  