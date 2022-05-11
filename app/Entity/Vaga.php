<?php

namespace App\Entity;

use App\Db\Database;
use PDO;

class Vaga {

    /**
     * Identificador único da vaga
     * @var int
     */
    public $id;

    /**
     * Título da vaga
     * @var string
     */
    public $titulo;

    /**
     * Descrição da vaga (pode conter HTML)
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga está ativa
     * @var string(s/n)
     */
    public $ativo;

    /**
     * Data de publicação da vaga
     * @var string
     */
    public $data;

    /**
     * Método responsável para cadastrar uma nova vaga no banco
     * @return bool
     */
    public function cadastrar() {

        // Definir a data
        $this->data = date('Y-m-d H:i:s');

        // Inserir a vaga no banco
        $obDatabase = new Database('vagas');
        $this->id = $obDatabase->insert([
                                            'titulo' => $this->titulo,
                                            'descricao' => $this->descricao,
                                            'ativo' => $this->ativo,
                                            'data' => $this->data
                                        ]);        

        // Retornar sucesso
        return true;

    }

    /**
     * Método responsável por atualizar um registro
     * @return bool
     */
    public function atualizar() {

        return (new Database('vagas'))->update( 'id = '.$this->id, [
                                                                    'titulo' => $this->titulo,
                                                                    'descricao' => $this->descricao,
                                                                    'ativo' => $this->ativo,
                                                                    'data' => $this->data
                                                                ]);

    }

    /**
     * Método responsável por excluir a vaga do banco
     * @return bool
     */
    public function excluir() {

        return (new Database('vagas'))->delete('id = '.$this->id);

    }

    /**
     * Método responsável por obter as vagas do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getVagas($where = null, $order = null, $limit = null) {

        return (new Database('vagas'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter uma vaga do banco de dados com base em seu ID
     * @param int $id     
     * @return Vaga
     */
    public static function getVaga($id) {

        return (new Database('vagas'))->select('id = '.$id)->fetchObject(self::class);
    }


}