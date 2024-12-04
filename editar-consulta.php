<?php
include_once("config.php");

// Verifica se o ID da consulta foi passado
if (isset($_GET['id'])) {
    $id_consulta = (int)$_GET['id'];

    if ($id_consulta > 0) {
        // Consulta os dados da consulta para editar
        $sql = "SELECT c.id_consulta, m.nome_medico, p.nome_paciente, c.data_consulta, c.hora_consulta 
                FROM consulta c 
                INNER JOIN medico m ON c.medico_id = m.id_medico
                INNER JOIN paciente p ON c.paciente_id = p.id_paciente
                WHERE c.id_consulta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_consulta);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $consulta = $result->fetch_assoc();
        } else {
            header("Location: ?page=listar-consulta&erro=Consulta não encontrada.");
            exit;
        }
    } else {
        header("Location: ?page=listar-consulta&erro=ID inválido.");
        exit;
    }
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    $nome_medico = $_POST['nome_medico'];
    $nome_paciente = $_POST['nome_paciente'];
    $data_consulta = $_POST['data_consulta'];
    $hora_consulta = $_POST['hora_consulta'];

    // Buscar os IDs do médico e do paciente
    $sqlMedico = "SELECT id_medico FROM medico WHERE nome_medico = ?";
    $stmtMedico = $conn->prepare($sqlMedico);
    $stmtMedico->bind_param("s", $nome_medico);
    $stmtMedico->execute();
    $resultMedico = $stmtMedico->get_result();
    $medico = $resultMedico->fetch_assoc();

    $sqlPaciente = "SELECT id_paciente FROM paciente WHERE nome_paciente = ?";
    $stmtPaciente = $conn->prepare($sqlPaciente);
    $stmtPaciente->bind_param("s", $nome_paciente);
    $stmtPaciente->execute();
    $resultPaciente = $stmtPaciente->get_result();
    $paciente = $resultPaciente->fetch_assoc();

    if ($medico && $paciente) {
        // Atualiza a consulta no banco de dados
        $sql = "UPDATE consulta 
                SET medico_id = ?, paciente_id = ?, data_consulta = ?, hora_consulta = ?
                WHERE id_consulta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissi", $medico['id_medico'], $paciente['id_paciente'], $data_consulta, $hora_consulta, $id_consulta);

        if ($stmt->execute()) {
            // Redireciona para a página inicial (home) após a edição
            header("Location: index.php?sucesso=Consulta editada com sucesso");
            exit;  // Garante que o código não continue executando após o redirecionamento
        } else {
            $erro = "Erro ao editar consulta: " . $stmt->error;
        }
    } else {
        $erro = "Médico ou Paciente não encontrados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<header class="bg-primary text-white text-center py-4">
    <h1>Gestão de Consultas</h1>
    <p>Editar Consulta</p>
</header>

<div class="container my-5">

    <!-- Mensagens de Sucesso e Erro -->
    <?php if (isset($erro)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $erro; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h2 class="mb-4">Editar Consulta</h2>

    <form action="?page=editar-consulta&id=<?php echo $consulta['id_consulta']; ?>" method="post">
        <input type="hidden" name="acao" value="editar">

        <div class="mb-3">
            <label for="nome_medico" class="form-label">Médico</label>
            <input type="text" class="form-control" id="nome_medico" name="nome_medico" value="<?php echo $consulta['nome_medico']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nome_paciente" class="form-label">Paciente</label>
            <input type="text" class="form-control" id="nome_paciente" name="nome_paciente" value="<?php echo $consulta['nome_paciente']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="data_consulta" class="form-label">Data da Consulta</label>
            <input type="date" class="form-control" id="data_consulta" name="data_consulta" value="<?php echo $consulta['data_consulta']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="hora_consulta" class="form-label">Hora da Consulta</label>
            <input type="time" class="form-control" id="hora_consulta" name="hora_consulta" value="<?php echo $consulta['hora_consulta']; ?>" required>
        </div>

        <button type="submit" class="btn btn-warning">Salvar Alterações</button>
        <a href="?page=listar-consulta" class="btn btn-secondary">Cancelar</a>
    </form>

</div>

<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Sistema de Gestão de Consultas</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>


