<?php
include_once("config.php");

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $acao = $_POST['acao'];

        if ($acao === "cadastrar") {
            // Preparar a instrução SQL para inserir o pagamento
            $sql = "INSERT INTO pagamento (paciente_id, valor_pagamento, data_pagamento) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ids", $paciente_id, $valor_pagamento, $data_pagamento);

            // Captura os dados do formulário
            $paciente_id = (int)$_POST['paciente_id'];
            $valor_pagamento = (float)$_POST['valor_pagamento'];
            $data_pagamento = $_POST['data_pagamento'];

            // Verifica se todos os campos estão preenchidos
            if (empty($paciente_id) || empty($valor_pagamento) || empty($data_pagamento)) {
                throw new Exception("Preencha todos os campos!");
            }

            // Executa a inserção
            if ($stmt->execute()) {
                // Redireciona para a lista de pagamentos após o cadastro
                header("Location: ?page=listar-pagamento&sucesso=Pagamento cadastrado com sucesso");
                exit; // Adiciona exit após o redirecionamento
            } else {
                throw new Exception("Erro ao cadastrar pagamento!");
            }
        } elseif ($acao === "editar") {
            // Editar pagamento existente
            $id_pagamento = (int)$_POST['id_pagamento'];
            $sql = "UPDATE pagamento SET paciente_id = ?, valor_pagamento = ?, data_pagamento = ? WHERE id_pagamento = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("idsi", $paciente_id, $valor_pagamento, $data_pagamento, $id_pagamento);

            // Captura os dados do formulário
            $paciente_id = (int)$_POST['paciente_id'];
            $valor_pagamento = (float)$_POST['valor_pagamento'];
            $data_pagamento = $_POST['data_pagamento'];

            // Verifica se todos os campos estão preenchidos
            if (empty($paciente_id) || empty($valor_pagamento) || empty($data_pagamento)) {
                throw new Exception("Preencha todos os campos!");
            }

            // Executa a atualização
            if ($stmt->execute()) {
                // Redireciona para a lista de pagamentos após a edição
                header("Location: ?page=listar-pagamento&sucesso=Pagamento atualizado com sucesso");
                exit; // Adiciona exit após o redirecionamento
            } else {
                throw new Exception("Erro ao atualizar pagamento!");
            }
        }
    }
} catch (Exception $e) {
    header("Location: ?page=cadastrar-pagamento&erro=" . urlencode($e->getMessage()));
    exit; // Adiciona exit após o redirecionamento
}

$conn->close();
?>