<?php

require __DIR__.'/vendor/autoload.php';

use \App\Entity\Vaga;
use \App\Db\Pagination;

// filtro busca
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// filtro status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// limita os valores válidos para o filtro status
$filtroStatus = in_array($filtroStatus, ['s', 'n']) ? $filtroStatus : '';

// condições SQL
$condicoes = [
    strlen($busca) ? 'titulo LIKE "%'.str_replace(' ', '%', $busca).'%"' : null,
    strlen($filtroStatus) ? 'ativo = "'.$filtroStatus.'"' : null
];

// remove posicoes vazias do array de $condicoes
$condicoes = array_filter($condicoes);

// junção das cláusulas WHERE no SQL
$where = implode(' AND ', $condicoes);

$quantidadeVagas = Vaga::getQuantidadeVagas($where);

// paginação
$obPagination = new Pagination($quantidadeVagas, $_GET['pagina'] ?? 1, 5);


// obtém todas as vagas cadastradas
$vagas = Vaga::getVagas($where, null, $obPagination->getLimit());

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/listagem.php';
include __DIR__ .'/includes/footer.php';

