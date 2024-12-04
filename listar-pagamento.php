<?php
include_once("config.php");

// Consultar os pagamentos e seus dados relacionados
$sql = "SELECT p.id_pagamento, pa.nome_paciente, p.valor_pagamento, p.data_pagamento 
        FROM pagamento p 
        INNER JOIN paciente pa ON p.paciente_id = pa.id_paciente
        ORDER BY p.data_pagamento DESC";  // Ordena por data (mais recente primeiro)
$res = $conn->query($sql);

// Verifica se há uma ação de exclusão
if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $id_pagamento = (int)$_GET['id'];

    if ($id_pagamento > 0) {
        // Prepara a instrução de exclusão
        $sqlDelete = "DELETE FROM pagamento WHERE id_pagamento = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id_pagamento);

        if ($stmtDelete->execute()) {
            // Redireciona para a lista de pagamentos após a exclusão
            header("Location: ?page=listar-pagamento&sucesso=Pagamento excluído com sucesso");
            exit; // Adiciona exit após o redirecionamento
        } else {
            header("Location: ?page=listar-pagamento&erro=Erro ao excluir o pagamento");
            exit; // Adiciona exit após o redirecionamento
        }
    } else {
        header("Location: ?page=listar-pagamento&erro=ID do pagamento inválido");
        exit; // Adiciona exit após o redirecionamento
    }
}
?>

<h1>Listar Pagamentos</h1>

<!-- Exibição das mensagens de sucesso e erro -->
<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_GET['sucesso']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_GET['erro']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Tabela de pagamentos -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">Paciente</th>
            <th scope="col">Valor do Pagamento</th>
            <th scope="col">Data do Pagamento</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($pagamento = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo $pagamento['nome_paciente']; ?></td>
                <td><?php echo number_format($pagamento['valor_pagamento'], 2, ',', '.'); ?></td>
                <td><?php echo date('d/m/Y', strtotime($pagamento['data_pagamento'])); ?></td>
                <td>
                    <a href="?page=editar-pagamento&id=<?php echo $pagamento['id_pagamento']; ?>" class='btn btn-warning'>Editar</a>
                    <a href="?page=listar-pagamento&acao=excluir&id=<?php echo $pagamento['id_pagamento']; ?>" 
                       class='btn btn-danger' onclick='return confirm("Deseja excluir este pagamento?")'>Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Botão para cadastrar novo pagamento -->
<a href="?page=cadastrar-pagamento" class='btn btn-primary'>Cadastrar Novo Pagamento</a>

<?php
// Fechando a conexão
$conn->close();
?>