<?php
include_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = isset($_POST['acao']) ? $_POST['acao'] : '';

    // Sanitize inputs
    $nome = isset($_POST["nome_medico"]) ? $conn->real_escape_string($_POST["nome_medico"]) : '';
    $crm = isset($_POST["crm_medico"]) ? $conn->real_escape_string($_POST["crm_medico"]) : '';
    $especialidade = isset($_POST["especialidade_medico"]) ? $conn->real_escape_string($_POST["especialidade_medico"]) : '';

    if ($acao == "cadastrar") {
        $sql = "INSERT INTO medico (nome_medico, crm_medico, especialidade_medico) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $crm, $especialidade);

        if ($stmt->execute()) {
            header("Location: listar-medico.php?sucesso=Médico cadastrado com sucesso!");
            exit();
        } else {
            header("Location: cadastrar-medico.php?erro=Erro ao cadastrar médico: " . $stmt->error);
            exit();
        }
        $stmt->close();
    } else if ($acao == "editar") {
        $id = isset($_POST["id_medico"]) ? (int)$_POST["id_medico"] : 0;

        if ($id > 0) {
            $sql = "UPDATE medico SET nome_medico=?, crm_medico=?, especialidade_medico=? WHERE id_medico=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nome, $crm, $especialidade, $id);

            if ($stmt->execute()) {
                header("Location: listar-medico.php?sucesso=Médico atualizado com sucesso!");
                exit();
            } else {
                header("Location: editar-medico.php?id_medico=$id&erro=Erro ao atualizar médico: " . $stmt->error);
                exit();
            }
            $stmt->close();
        } else {
            header("Location: listar-medico.php?erro=ID inválido para edição.");
            exit();
        }
    } else {
        header("Location: listar-medico.php?erro=Ação inválida ao cadastrar ou editar.");
        exit();
    }
} else if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $id = (int)$_GET["id"];

        // Verifica se há consultas associadas ao médico
        $sql = "SELECT COUNT(*) AS total FROM consulta WHERE medico_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalConsultas = $row['total'];
        $stmt->close();

        if ($totalConsultas > 0) {
            header("Location: listar-medico.php?erro=Não é possível excluir o médico. Existem consultas agendadas.");
            exit();
        } else {
            // Exclui o médico
            $sql = "DELETE FROM medico WHERE id_medico = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header("Location: listar-medico.php?sucesso=Médico excluído com sucesso!");
                exit();
            } else {
                header("Location: listar-medico.php?erro=Erro ao excluir médico.");
                exit();
            }
            $stmt->close();
        }
    } else {
        header("Location: listar-medico.php?erro=ID inválido para exclusão.");
        exit();
    }
} else {
    header("Location: listar-medico.php?erro=Método ou ação inválida.");
    exit();
}

$conn->close();
?>

