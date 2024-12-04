<?php
include_once("config.php");

// Consultar as consultas e seus dados relacionados
$sql = "SELECT c.id_consulta, m.nome_medico, p.nome_paciente, c.data_consulta, c.hora_consulta 
        FROM consulta c 
        INNER JOIN medico m ON c.medico_id = m.id_medico
        INNER JOIN paciente p ON c.paciente_id = p.id_paciente
        ORDER BY c.data_consulta DESC";  // Ordena por data (mais recente primeiro)
$res = $conn->query($sql);

// Verifica se há uma ação de exclusão
if (isset($_GET['acao']) && $_GET['acao'] === 'excluir' && isset($_GET['id'])) {
    $id_consulta = (int)$_GET['id'];

    if ($id_consulta > 0) {
        // Prepara a instrução de exclusão
        $sqlDelete = "DELETE FROM consulta WHERE id_consulta = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id_consulta);

        if ($stmtDelete->execute()) {
            header("Location: ?page=listar-consulta&sucesso=Consulta excluída com sucesso");
            exit;
        } else {
            header("Location: ?page=listar-consulta&erro=Erro ao excluir a consulta");
            exit;
        }
    } else {
        header("Location: ?page=listar-consulta&erro=ID da consulta inválido");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Consultas</title>
    <!-- Link do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Cabeçalho -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Gestão de Consultas</h1>
        <p>Consulte, edite e exclua consultas agendadas</p>
    </header>

    <div class="container my-5">
        <!-- Mensagens de Sucesso e Erro -->
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

        <h2 class="mb-4">Lista de Consultas</h2>

        <!-- Tabela de consultas -->
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">Médico</th>
                    <th scope="col">Paciente</th>
                    <th scope="col">Data da Consulta</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($consulta = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $consulta['nome_medico']; ?></td>
                        <td><?php echo $consulta['nome_paciente']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?></td>
                        <td><?php echo $consulta['hora_consulta']; ?></td>
                        <td>
                            <!-- Link de edição para redirecionar para a página de edição -->
                            <a href="editar-consulta.php?id=<?php echo $consulta['id_consulta']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="?page=listar-consulta&acao=excluir&id=<?php echo $consulta['id_consulta']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir esta consulta?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Botão para cadastrar nova consulta -->
        <a href="?page=cadastrar-consulta" class="btn btn-primary btn-lg">Cadastrar Nova Consulta</a>
    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Sistema de Gestão de Consultas</p>
    </footer>

</body>
</html>

<?php
// Fechando a conexão
$conn->close();
?>

