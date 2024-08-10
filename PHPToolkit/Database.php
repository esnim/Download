<?php
namespace PHPToolkit;

class Database
{
    /**
     * 
     * @var \PDO
     */
    protected $pdo;
    protected $database = array();
    
    public function __construct(array $credentials)
    {
        $this->database = array(
            'host' => $credentials['host'],
            'name' => $credentials['name'],
            'user' => $credentials['user'],
            'pass' => $credentials['pass'],
        );
    }
    
    public function connect()
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s', $this->database['host'], $this->database['name']);

        $options = array(
            
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,            
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            
            // Evitar que rowCount() devuelva 0 como resultado cuando se ejecuta
            // una consulta UPDATE con los mismos valores que ya están guardados:
            \PDO::MYSQL_ATTR_FOUND_ROWS   => true,
            
            // Evitar el error de PDO cuando se usa un valor preparado en una
            // instrucción "LIMIT :limit" o "LIMIT ?":
            \PDO::ATTR_EMULATE_PREPARES   => false,
            
        );

        $this->pdo = new \PDO($dsn, $this->database['user'], $this->database['pass'], $options);    
    }
    
    public function disconnect()
    {
        $this->pdo = null;
    }   
    
    /**
     * 
     * @return bool
     */
    public function isConnected()
    {
        return (bool) $this->pdo;
    }
    
    /**
     * 
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->pdo;
    }
}
