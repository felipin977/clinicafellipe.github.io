<?php
include_once("config.php");

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $acao = $_POST['acao'];

        if ($acao === "cadastrar") {
            // Cadastrar nova consulta
            $sql = "INSERT INTO consulta (medico_id, paciente_id, data_consulta, hora_consulta, descricao_consulta) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisss", $medico_id, $paciente_id, $data_consulta, $hora_consulta, $descricao_consulta);

            // Captura os dados do formulário
            $medico_id = (int)$_POST['medico_id'];
            $paciente_id = (int)$_POST['paciente_id'];
            $data_consulta = $_POST['data_consulta'];
            $hora_consulta = $_POST['hora_consulta'];
            $descricao_consulta = $_POST['descricao_consulta'];

            // Verifica se todos os campos estão preenchidos
            if (empty($medico_id) || empty($paciente_id) || empty($data_consulta) || empty($hora_consulta)) {
                throw new Exception("Preencha todos os campos!");
            }

            // Verifica se já existe consulta
            $sqlVerifica = "SELECT 1 FROM consulta WHERE medico_id = ? AND data_consulta = ? AND hora_consulta = ?";
            $stmtVerifica = $conn->prepare($sqlVerifica);
            $stmtVerifica->bind_param("iss", $medico_id, $data_consulta, $hora_consulta);
            $stmtVerifica->execute();
            $resultVerifica = $stmtVerifica->get_result();

            if ($resultVerifica->num_rows > 0) {
                throw new Exception("Já existe uma consulta para o médico e horário informados.");
            }

            // Executa a inserção
            if ($stmt->execute()) {
                header("Location: ?page=listar-consulta&sucesso=Consulta cadastrada com sucesso");
                exit; // Adiciona exit após o redirecionamento
            } else {
                throw new Exception("Erro ao cadastrar consulta!");
            }
        } elseif ($acao === "editar") {
            // Editar consulta existente
            $id_consulta = (int)$_POST['id_consulta'];
            $sql = "UPDATE consulta SET medico_id = ?, paciente_id = ?, data_consulta = ?, hora_consulta = ?, descricao_consulta = ? WHERE id_consulta = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisssi", $medico_id, $paciente_id, $data_consulta, $hora_consulta, $descricao_consulta, $id_consulta);

            // Captura os dados do formulário
            $medico_id = (int)$_POST['medico_id'];
            $paciente_id = (int)$_POST['paciente_id'];
            $data_consulta = $_POST['data_consulta'];
            $hora_consulta = $_POST['hora_consulta'];
            $descricao_consulta = $_POST['descricao_consulta'];

            // Executa a atualização
            if ($stmt->execute()) {
                header("Location: ?page=listar-consulta&sucesso=Consulta atualizada com sucesso");
                exit; // Adiciona exit após o redirecionamento
            } else {
                throw new Exception("Erro ao atualizar consulta!");
            }
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['acao']) && $_GET['acao'] === "excluir") {
        // Excluir consulta
        $id_consulta = (int)$_GET['id'];

        if ($id_consulta > 0) {
            // Prepara a instrução de exclusão
            $sqlDelete = "DELETE FROM consulta WHERE id_consulta = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $id_consulta);

            if ($stmtDelete->execute()) {
                header("Location: ?page=listar-consulta&sucesso=Consulta excluída com sucesso");
                exit; // Adiciona exit após o redirecionamento
            } else {
                header("Location: ?page=listar-consulta&erro=Erro ao excluir a consulta");
                exit; // Adiciona exit após o redirecionamento
            }
        } else {
           header("Location: ?page=listar-consulta&erro=ID da consulta inválido");
           exit; // Adiciona exit após o redirecionamento
        }
    }
} catch (Exception $e) {
    header("Location: ?page=cadastrar-consulta&erro=" . urlencode($e->getMessage()));
    exit; // Adiciona exit após o redirecionamento
}

$conn->close();
?>