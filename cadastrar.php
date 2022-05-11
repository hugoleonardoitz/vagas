<?php

require __DIR__.'/vendor/autoload.php';

// campo título do HTML de forma dinâmica
define('TITLE', 'Cadastrar Vaga');

use \App\Entity\Vaga;

// limpar os campos do formulário HTML
$titulo = '';
$descricao = '';
$ativo = '';

// instancia o objeto da vaga
$obVaga = new Vaga();

// Validação do POST
if(isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'])) {
        
    // obtem os campos prenchidos do formulário HTML
    $obVaga->titulo = $_POST['titulo'];
    $obVaga->descricao = $_POST['descricao'];
    $obVaga->ativo = $_POST['ativo'];

    // envia os dados para o método cadastrar vaga
    $obVaga->cadastrar();

    // redireciona para a página inicial com status de sucesso
    header('location: index.php?status=success');
    exit;

}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/formulario.php';
include __DIR__ .'/includes/footer.php';

