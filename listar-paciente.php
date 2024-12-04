<?php
include_once("config.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Pacientes - Clínica Médica</title>
    <!-- Link do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Cabeçalho -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Gestão de Pacientes</h1>
        <p>Consulte, edite e exclua pacientes cadastrados</p>
    </header>

    <div class="container my-5">
        <!-- Mensagens de Sucesso e Erro -->
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['sucesso']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['erro']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Botão para Adicionar Paciente -->
        <div class="text-end mb-3">
            <a href="../Projeto Fellipe/cadastrar-paciente.php" class="btn btn-success btn-lg">Adicionar Novo Paciente</a>
        </div>

        <?php
        // Consultar os pacientes
        $sql = "SELECT * FROM paciente ORDER BY nome_paciente";
        $res = $conn->query($sql);

        if ($res === false) {
            echo "<p class='alert alert-danger'>Erro na consulta ao banco de dados.</p>";
            exit;
        }

        $qtd = $res->num_rows;

        if ($qtd > 0) {
            echo "<p>Encontrou <b>$qtd</b> resultado(s)</p>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<thead class='table-light'>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Sexo</th>
                        <th>Endereço</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while ($row = $res->fetch_object()) {
                // Formatação do sexo para exibição
                $sexo = ($row->sexo_paciente == 'M') ? 'Masculino' : 'Feminino';

                echo "<tr>";
                echo "<td>" . htmlspecialchars($row->id_paciente) . "</td>";
                echo "<td>" . htmlspecialchars($row->nome_paciente) . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($row->data_nasc_paciente)) . "</td>";
                echo "<td>" . htmlspecialchars($row->cpf_paciente) . "</td>";
                echo "<td>" . htmlspecialchars($row->email_paciente) . "</td>";
                echo "<td>" . $sexo . "</td>";
                echo "<td>" . htmlspecialchars($row->endereco_paciente) . "</td>";
                echo "<td>" . htmlspecialchars($row->telefone) . "</td>";
                echo "<td>
                        <a href='editar-paciente.php?id=" . htmlspecialchars($row->id_paciente) . "' class='btn btn-warning btn-sm'>Editar</a> 
                        <a href='?page=salvar-paciente&acao=excluir&id=" . htmlspecialchars($row->id_paciente) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Tem certeza que deseja excluir este paciente?');\">Excluir</a>
                      </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p class='alert alert-warning'>Não foram encontrados pacientes cadastrados.</p>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Sistema de Gestão de Pacientes</p>
    </footer>

</body>
</html>
