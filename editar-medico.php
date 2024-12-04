<?php
include_once("config.php");

$titulo = "Cadastrar Médico";
$acao = "cadastrar";
$medico = [];

if (isset($_GET["id_medico"]) && is_numeric($_GET["id_medico"])) {
    $id_medico = (int)$_GET["id_medico"];
    $sql = "SELECT * FROM medico WHERE id_medico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_medico);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $medico = $result->fetch_assoc();
        $titulo = "Editar Médico";
        $acao = "editar";
    } else {
        echo "<div class='alert alert-danger'>Médico não encontrado.</div>";
        exit;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <!-- Importando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; /* Fundo azul claro */
            padding-top: 50px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #007bff; /* Azul para o título */
        }
        .btn-cancel {
            margin-left: 10px;
        }
        .btn-primary {
            background-color: #007bff; /* Azul para o botão principal */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545; /* Vermelho para o botão cancelar */
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="text-center"><?php echo $titulo; ?></h1>
            <form action="salvar-medico.php" method="post">
                <input type="hidden" name="acao" value="<?php echo $acao; ?>">
                <input type="hidden" name="id_medico" value="<?php echo $medico['id_medico'] ?? ''; ?>">

                <!-- Nome Médico -->
                <div class="mb-3">
                    <label for="nome_medico" class="form-label">Nome</label>
                    <input type="text" name="nome_medico" id="nome_medico" class="form-control" value="<?php echo htmlspecialchars($medico['nome_medico'] ?? ''); ?>" required>
                </div>

                <!-- CRM Médico -->
                <div class="mb-3">
                    <label for="crm_medico" class="form-label">CRM</label>
                    <input type="text" name="crm_medico" id="crm_medico" class="form-control" value="<?php echo htmlspecialchars($medico['crm_medico'] ?? ''); ?>" required>
                </div>

                <!-- Especialidade -->
                <div class="mb-3">
                    <label for="especialidade_medico" class="form-label">Especialidade</label>
                    <input type="text" name="especialidade_medico" id="especialidade_medico" class="form-control" value="<?php echo htmlspecialchars($medico['especialidade_medico'] ?? ''); ?>" required>
                </div>

                <!-- Botões de Enviar e Cancelar -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary"><?php echo ($acao == "editar" ? "Atualizar" : "Cadastrar"); ?></button>
                    <a href="listar-medico.php" class="btn btn-danger btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>


