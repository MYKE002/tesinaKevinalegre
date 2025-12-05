<?php

class Query extends Conexion
{
    private $pdo, $con, $sql, $datos;

    public function __construct()
    {
        $this->pdo = new Conexion();
        $this->con = $this->pdo->conect();
    }

    // Realizar una consulta SELECT que espera un solo resultado
    public function select(string $sql)
    {
        try {
            $this->sql = $sql;
            $resul = $this->con->prepare($this->sql);
            $resul->execute();
            $data = $resul->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            // Manejar errores de PDO
            echo 'Error en consulta SELECT: ' . $e->getMessage();
        }
    }

    // Realizar una consulta SELECT que espera varios resultados
    public function selectAll(string $sql)
    {
        try {
            $this->sql = $sql;
            $resul = $this->con->prepare($this->sql);
            $resul->execute();
            $data = $resul->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            // Manejar errores de PDO
            echo 'Error en consulta SELECT ALL: ' . $e->getMessage();
        }
    }

    // Realizar una consulta de inserción o actualización
    public function save(string $sql, array $datos)
    {
        try {
            $this->sql = $sql;
            $this->datos = $datos;
            $insert = $this->con->prepare($this->sql);
            $data = $insert->execute($this->datos);
            
            // Verificar si la consulta fue exitosa
            return $data ? 1 : 0;
        } catch (PDOException $e) {
            // Manejar errores de PDO
            echo 'Error en consulta SAVE: ' . $e->getMessage();
        }
    }

    // Agregar más métodos según sea necesario
}

?>
