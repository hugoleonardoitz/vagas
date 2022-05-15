<?php

namespace App\Db;

class Pagination {

    /**
     * Número mmáximo de registros por página
     */
    private $limit;

    /**
     * Quantidade total de resultados do banco
     * @var int
     */
    private $results;

    /**
     * Quantidade de páginas
     * @var int
     */
    private $pages;

    /**
     * Página atual
     * @var int
     */
    private $currentPage;

    /**
     * Construtor da classe
     * @param int $results
     * @param int $currentPage
     * @param int $limit
     */
    public function __construct($results, $currentPage = 1, $limit = 10) {

        $this->results = $results;
        $this->limit = $limit;
        $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
        $this->calculate();
    }

    /**
     * Método responsável por calcular a paginação
     */
    private function calculate() {
        // calcula o total de páginas
        $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

        // verifica se a página atual não excede o número de páginas
        $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    /**
     * Método responsável por retornar a cláusula LIMIT do SQL
     * @return string
     */
    public function getLimit() {

        $offset = ($this->limit * ($this->currentPage - 1));
        return $offset.','.$this->limit;

    }

    /**
     * Método responsável por retornar as opções de páginas disponíveis
     * @return array
     */
    public function getPages() {

        // não retorna páginas
        if($this->pages == 1) return [];

        // páginas
        $paginas = [];
        for($i = 1; $i <= $this->pages; $i++) {
            $paginas[] = [
                'pagina' => $i,
                'atual' => $i == $this->currentPage
            ];
        }
        return $paginas;

    }

}