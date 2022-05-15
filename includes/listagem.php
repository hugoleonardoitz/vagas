<?php
// alerta para o status das ações
$mensagem = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
            break;

        case 'error':
            $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
            break;
    }
}

// listagem das vagas
$resultados = '';
foreach ($vagas as $vaga) {
    $resultados .=
        '<tr>
            <td>' . $vaga->id  . '</td>
            <td>' . $vaga->titulo . '</td>
            <td>' . $vaga->descricao . '</td>
            <td>' . ($vaga->ativo == 's' ? 'Ativo' : 'Inativo') . '</td>
            <td>' . date('d/m/Y H:i:s', strtotime($vaga->data)) . '</td>
            <td>
                <a href="editar.php?id=' . $vaga->id . ' ">
                    <button type="button" class="btn btn-primary">
                        Editar
                    </button>
                </a>
                <a href="excluir.php?id=' . $vaga->id . ' ">
                    <button type="button" class="btn btn-danger">
                        Excluir
                    </button>
                </a>
            </td>
        </tr>';
}
// caso não possua vaga cadastrada, substituir por aviso
$resultados = strlen($resultados) ? $resultados :
    '<tr>
            <td colspan="6" class="text-center">
                Nenhuma vaga encontrada
            </td>
        </tr>';

// GETS
unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

// paginacao
$paginacao = '';
$paginas = $obPagination->getPages();
foreach ($paginas as $key=>$value) {
    
    // deixa o botão azul, se página atual, se não, cinxa claro
    $corBotao = $value['atual'] ? 'btn-primary' : 'btn-light';
    
    // númera o botões
    $paginacao .= '<a href="?pagina='.$value['pagina'].'&'.$gets.'">
                        <button type="button" class="btn '.$corBotao.'">'.$value['pagina'].'</button>
                   </a>';
}

?>
<main>
    <?= $mensagem ?>
    <section>
        <a href="cadastrar.php">
            <button class="btn btn-success">Nova vaga</button>
        </a>
    </section>

    <section>
        <form method="get">
            <div class="row my-4">
                <div class="col">
                    <label>Buscar por título</label>
                    <input type="text" name="busca" class="form-control" value="<?= $busca ?>">
                </div>
                <div class="col-2">
                    <label>Status</label>
                    <select name="filtroStatus" class="form-control">
                        <option value="">Todas</option>
                        <option value="s" <?= $filtroStatus == 's' ? 'selected' : '' ?>>Ativas</option>
                        <option value="n" <?= $filtroStatus == 'n' ? 'selected' : '' ?>>Inativas</option>
                    </select>
                </div>
                <div class="col d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>
    </section>

    <section>
        <table class="table bg-light mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?= $resultados ?>
            </tbody>
        </table>
    </section>

    <section>
        <?=$paginacao?>
    </section>
</main>