<?php
include_once("config.php");

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $acao = $_POST['acao'];

        if ($acao === "cadastrar") {
            // Código para cadastrar paciente (não mostrado aqui)
        } elseif ($acao === "editar") {
            // Código para editar paciente (não mostrado aqui)
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['acao']) && $_GET['acao'] === 'excluir') {
        // Exclusão de paciente
        $id_paciente = (int)$_GET['id'];

        if ($id_paciente > 0) {
            // Prepara a instrução de exclusão
            $sqlDelete = "DELETE FROM paciente WHERE id_paciente = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $id_paciente);

            if ($stmtDelete->execute()) {
                header("Location: ?page=listar-paciente&sucesso=Paciente excluído com sucesso");
                exit; // Adiciona exit após o redirecionamento
            } else {
                header("Location: ?page=listar-paciente&erro=Erro ao excluir o paciente");
                exit; // Adiciona exit após o redirecionamento
            }
        } else {
            header("Location: ?page=listar-paciente&erro=ID do paciente inválido");
            exit; // Adiciona exit após o redirecionamento
        }
    }
} catch (Exception $e) {
    header("Location: ?page=listar-paciente&erro=" . urlencode($e->getMessage()));
    exit; // Adiciona exit após o redirecionamento
}

$conn->close();
?>