<?php
class Conexion
{
    private $servidor;
    private $usuario;
    private $password;
    private $puerto;
    private $baseDatos;
    private $pdo;

    public function __construct()
    {
        $this->servidor = "bnn225gxjfyzkrlefw6z-mysql.services.clever-cloud.com";
        $this->usuario = "ubk2iqduknniaxq7";
        $this->password = "bZi1il7kN236oKOrMHJp";
        $this->puerto = "3306";
        $this->baseDatos = "bnn225gxjfyzkrlefw6z";
        $this->conectar();
    }

    public function conectar()
    {
        try {
            $dsn = "mysql:host=$this->servidor;port=$this->puerto;dbname=$this->baseDatos;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            if ($this->pdo === null) {
                $this->pdo = new PDO($dsn, $this->usuario, $this->password, $options);
                
            }
            return $this->pdo;
        } catch (PDOException $e) {
            throw new Exception('Error en la conexión: ' . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    // Función genérica para SELECT
    public function select($query, $params = [])
    {
        try {
            if ($this->pdo === null) {
                $this->conectar();
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception('Error al consultar: ' . $e->getMessage());
        }
    }

    // Función genérica para UPDATE
    public function update($query, $params)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params); // Ejecuta la consulta
            return $stmt; // Devuelve el objeto PDOStatement para obtener rowCount
        } catch (PDOException $e) {
            throw new Exception('Error al actualizar: ' . $e->getMessage());
        }
    }

    // Función genérica para DELETE
    public function delete($query, $params)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params); // Ejecuta la consulta
            return $stmt; // Devuelve el objeto PDOStatement para obtener rowCount
        } catch (PDOException $e) {
            throw new Exception('Error al eliminar: ' . $e->getMessage());
        }
    }

    // Función genérica para INSERT
    public function insert($query, $params = [])
    {
        try {
            if ($this->pdo === null) {
                $this->conectar();
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $this->pdo->lastInsertId(); // Retorna el ID del último registro insertado
        } catch (PDOException $e) {
            throw new Exception('Error al insertar: ' . $e->getMessage());
        }
    }

    // Función para obtener el número de filas afectadas
    public function rowCount($stmt)
    {
        return $stmt->rowCount(); // Devuelve el número de filas afectadas por la última consulta
    }

    public function execute($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt; // Devuelve el objeto PDOStatement
    }
}
