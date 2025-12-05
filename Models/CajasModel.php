<?php
class cajasModel extends Query
{
    private $caja, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }

    public function getCajas(string $table)
    {
        $sql = "SELECT * FROM $table";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarCaja(string $caja)
    {
        $this->caja = $caja;
        $verificar = "SELECT * FROM cajas WHERE caja = '$this->caja'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO cajas(caja) VALUES (?)";
            $datos = array($this->caja);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }

        return $res;
    }

    public function editarCaja(int $id)
    {
        $sql = "SELECT * FROM cajas WHERE id = $id";
        $data = $this->select($sql);

        return $data;
    }

    public function modificarCaja(string $caja, int $id)
    {
        $this->caja = $caja;
        $this->id = $id;
        $sql = "UPDATE cajas SET caja = ? WHERE id = ?";
        $datos = array($this->caja, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function accionCaja(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE cajas SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function registrarArqueo(int $id_usuario, string $monto_inicial, $fecha_apertura)
    {
        $verificar = "SELECT * FROM cierre_caja WHERE id_usuario = '$id_usuario' AND estado = 1";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO cierre_caja(id_usuario, monto_inicial, fecha_apertura) VALUES (?, ?, ?)";
            $datos = array($id_usuario, $monto_inicial, $fecha_apertura);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }

        return $res;
    }


    public function prueba(int $id_usuario)
    {
        $sql = "SELECT * FROM cierre_caja WHERE id_usuario = '$id_usuario' AND estado = 1";
        $data = $this->select($sql);
        
        return $data;
    }

    public function getVentas(int $id_user)
    {
        $sql = "SELECT IFNULL(total, 0), IFNULL(SUM(total), 0) as total FROM ventas WHERE id_usuario = $id_user AND estado = 1 AND apertura = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function getTotalVentas(int $id_user)
    {
        $sql = "SELECT COUNT(total) as total FROM ventas WHERE id_usuario = $id_user AND estado = 1 AND apertura = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function getMontoInicial(int $id_user)
    {
        $sql = "SELECT id, monto_inicial FROM cierre_caja WHERE id_usuario = $id_user AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function actualizarArqueo(string $final, string $cierre, string $ventas, string $general,  int $id)
    {
        $sql = "UPDATE cierre_caja SET monto_final =?, fecha_cierre = ?, total_ventas = ?, monto_total = ? , estado = ? WHERE id = ?";
        $datos = array($final, $cierre, $ventas, $general, 0, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }

        return $res;
    }

    public function actualizarApertura(int $id)
    {
        $sql = "UPDATE ventas SET apertura =? WHERE id_usuario = ?";
        $datos = array(0, $id);
        $this->save($sql, $datos);
    }

    public function verificarPermisos(int $id_user, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
