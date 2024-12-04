<?php
include_once("config.php");

// Processando o formulário de cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    // Coletando os dados do formulário
    $nome = $_POST['nome_paciente'];
    $data_nasc = $_POST['data_nasc_paciente'];
    $cpf = $_POST['cpf_paciente'];
    $email = $_POST['email_paciente'];
    $sexo = $_POST['sexo_paciente'];
    $endereco = $_POST['endereco_paciente'];
    $telefone = $_POST['telefone'];

    // Validar os dados (exemplo básico)
    if (empty($nome) || empty($cpf) || empty($email)) {
        $erro = "Nome, CPF e Email são obrigatórios.";
    } else {
        // Preparando a query de inserção no banco
        $sql = "INSERT INTO paciente (nome_paciente, data_nasc_paciente, cpf_paciente, email_paciente, sexo_paciente, endereco_paciente, telefone)
                VALUES ('$nome', '$data_nasc', '$cpf', '$email', '$sexo', '$endereco', '$telefone')";

        // Executando a query
        if ($conn->query($sql) === TRUE) {
            // Se a inserção for bem-sucedida
            $sucesso = "Paciente cadastrado com sucesso!";
        } else {
            // Se ocorrer algum erro na execução da query
            $erro = "Erro ao cadastrar paciente: " . $conn->error;
        }
    }
}

// Fechar a conexão com o banco de dados após a operação
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Paciente - Clínica Médica</title>
    <!-- Link do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Cabeçalho -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Gestão de Pacientes</h1>
        <p>Cadastro de novos pacientes</p>
    </header>

    <div class="container my-5">
        <!-- Mensagens de Sucesso e Erro -->
        <?php if (isset($sucesso)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($sucesso); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($erro); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Cadastrar Novo Paciente</h2>

        <form action="?page=cadastrar-paciente" method="post">
            <input type="hidden" name="acao" value="cadastrar">

            <div class="mb-3">
                <label for="nome_paciente" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome_paciente" name="nome_paciente" required>
            </div>

            <div class="mb-3">
                <label for="data_nasc_paciente" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nasc_paciente" name="data_nasc_paciente" required>
            </div>

            <div class="mb-3">
                <label for="cpf_paciente" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf_paciente" name="cpf_paciente" required oninput="maskCPF()">
            </div>

            <div class="mb-3">
                <label for="email_paciente" class="form-label">Email</label>
                <input type="email" class="form-control" id="email_paciente" name="email_paciente" required>
            </div>

            <div class="mb-3">
                <label for="sexo_paciente" class="form-label">Sexo</label>
                <select class="form-control" id="sexo_paciente" name="sexo_paciente" required>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="endereco_paciente" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco_paciente" name="endereco_paciente">
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" oninput="maskPhone()">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success">Cadastrar</button>
                <a href="../Projeto-Fellipe/listar-paciente.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>

        <!-- Botão para voltar à home -->
        <div class="mt-4">
            <a href="http://localhost/Projeto%20Fellipe/" class="btn btn-primary">Voltar para a Home</a>
        </div>

    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Sistema de Gestão de Pacientes</p>
    </footer>

    <script>
        function maskCPF() {
            let cpf = document.getElementById('cpf_paciente').value;
            cpf = cpf.replace(/\D/g, ''); // Remove caracteres não numéricos
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            document.getElementById('cpf_paciente').value = cpf;
        }

        function maskPhone() {
            let phone = document.getElementById('telefone').value;
            phone = phone.replace(/\D/g, ''); // Remove caracteres não numéricos
            phone = phone.replace(/(\d{2})(\d)/, '($1) $2');
            phone = phone.replace(/(\d{5})(\d)/, '$1-$2');
            document.getElementById('telefone').value = phone;
        }
    </script>

</body>
</html>





