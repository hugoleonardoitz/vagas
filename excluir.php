<?php

require __DIR__.'/vendor/autoload.php';

use \App\Entity\Vaga;

// Validação do ID
if(!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');
    exit;
}

// Consulta a vaga pelo ID
$obVaga = Vaga::getVaga($_GET['id']);

// Validação da vaga
if (!$obVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
} 

// Validação do POST
if(isset($_POST['excluir'])) {    
      
    // chama o meótodo excluir da vaga selecionada via ID
    $obVaga->excluir();
    
    // redireciona para a página inicial com status de sucesso
    header('location: index.php?status=success');
    exit;

}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/confirmar-exclusao.php';
include __DIR__ .'/includes/footer.php';

