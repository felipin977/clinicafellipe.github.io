<?php include_once("config.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Médicos</title>
    <!-- Link do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Cabeçalho -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Gestão de Médicos</h1>
        <p>Consulte, edite e exclua médicos cadastrados</p>
    </header>

    <div class="container my-5">
        <!-- Mensagens de Sucesso e Erro -->
        <?php
        if (isset($_GET['sucesso'])) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . $_GET['sucesso'] . 
                 "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
        if (isset($_GET['erro'])) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" . $_GET['erro'] . 
                 "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
        ?>

        <h2 class="mb-4">Lista de Médicos</h2>

        <?php
        $sql = "SELECT * FROM medico ORDER BY nome_medico";
        $res = $conn->query($sql);
        $qtd = $res->num_rows;

        if ($qtd > 0) {
            echo "<p>Encontrou <strong>$qtd</strong> resultado(s)</p>";
            echo "<table class='table table-striped table-bordered table-hover'>
                    <thead class='table-light'>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CRM</th>
                            <th>Especialidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($row = $res->fetch_object()) {
                echo "<tr>";
                echo "<td>" . $row->id_medico . "</td>";
                echo "<td>" . $row->nome_medico . "</td>";
                echo "<td>" . $row->crm_medico . "</td>";
                echo "<td>" . $row->especialidade_medico . "</td>";
                echo "<td>
                        <a href='editar-medico.php?id=" . $row->id_medico . "' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='salvar-medico.php?acao=excluir&id=" . $row->id_medico . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Tem certeza que deseja excluir este médico?');\">Excluir</a>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p class='alert alert-warning'>Não foram encontrados médicos cadastrados.</p>";
        }

        $conn->close(); // Importante: feche a conexão após o uso
        ?>

        <!-- Botão Voltar para a Home -->
        <div class="d-flex justify-content-center mt-4">
            <a href="index.php" class="btn btn-success">Voltar para a Home</a>
        </div>

    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Sistema de Gestão de Médicos</p>
    </footer>

</body>
</html>
