<?php

namespace App\Db;
use PDO;
use PDOException;

class Database {

    /**
     * Host de conexão com o banco de dados
     * @var string 
     */
    const HOST = 'localhost';
    
    /**
     * Nome do banco de dados
     * @var string
     */
    const  NAME = 'wdev_vagas';

    /**
     * Usuário do banco de dados
     * @var string
     */
    const USER = 'root';

    /**
     * Senha do usuário do banco de dados
     * @var string
     */
    const PASS = '';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instância de conexão com banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Construtor que define a tabela e instância da conexão
     * @param string $table
     */
    public function __construct($table = null) {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar uma conexão com o banco de dados
     */
    private function setConnection() {
        try {
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR:'.$e->getMessage());
        }
    }

    /**
     * método responsável por executar queries dentro do banco de dados
     * @param string $query
     * @param array $paramns
     * @return PDOStatement
     */
    public function execute($query, $params = []) {

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }

    }

    /**
     * Método resposável por inserir dados no banco
     * @param array $values [ field => value ]
     * @return int
     */
    public function insert($values) {
        
        // dados da query
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        // monta a query
        $query = 'INSERT INTO ' . $this->table . ' ('.implode(',', $fields).') VALUES ('.implode(',', $binds).')';
        /* echo "<pre>"; print_r($query);  echo "</pre>"; exit; */
        
        // executa o insert
        $this->execute($query, array_values($values));

        // retorna o ID inserido
        return $this->connection->lastInsertId();
    }

    /**
     * Método responsável por executar uma consulta no banco
     * @param string $where
     * @param string $order
     * @param $limit
     * @param $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*') {

        // dados da query
        $where = strlen($where) ? 'WHERE ' .$where : '';
        $order = strlen($order) ? 'ORDER BY ' .$order : '';
        $limit = strlen($limit) ? 'LIMIT ' .$limit : '';

        // monta a query
        $query = 'SELECT ' .$fields. ' FROM '. $this->table.' '.$where. ' '.$order.' '.$limit;

        return $this->execute($query);
    }

    /**
     * Método responsável por executar atualizações no banco de dados
     * @param $where
     * @param  array $values [ filed => value ]
     * @return bool
     */
    public function update($where, $values) {

        // dados da query
        $fields = array_keys($values);       

        // monta a query
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

        // executa a query
        $this->execute($query, array_values($values));

        // retorna true
        return true;

    }

    /**
     * Método responsável por excluir um registro do banco
     * @param string $where
     * @return bool
     */
    public function delete($where) {

        // monta a query
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

        // executa a query
        $this->execute($query);

        // retorna sucesso
        return true;

    }

}