<?php

require __DIR__.'/vendor/autoload.php';

// campo título do HTML de forma dinâmica
define('TITLE', 'Editar Vaga');

use \App\Entity\Vaga;

// Validação do ID
if(!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');
    exit;
}

// Consulta a vaga
$obVaga = Vaga::getVaga($_GET['id']);

// Validação a vaga
if (!$obVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
} else { // carrega os campos para exibir no formulário HTML
    $titulo = $obVaga->titulo;
    $descricao = $obVaga->descricao;
    $ativo = $obVaga->ativo;
}

// Validação do POST
if(isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'])) {
    
    // obtem os campos modificados ou não do formulário HTML
    $obVaga->titulo = $_POST['titulo'];
    $obVaga->descricao = $_POST['descricao'];
    $obVaga->ativo = $_POST['ativo'];
    
    // envia os dados para o método atualizar vaga
    $obVaga->atualizar();

    // redireciona para a página inicial com status de sucesso
    header('location: index.php?status=success');
    exit;

}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/formulario.php';
include __DIR__ .'/includes/footer.php';

