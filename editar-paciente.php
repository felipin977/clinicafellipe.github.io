<?php
include_once("config.php");

$titulo = "Cadastrar Paciente";
$acao = "cadastrar";
$paciente = [];

if(isset($_REQUEST["id"]) && is_numeric($_REQUEST["id"])) {
    $id_paciente = (int)$_REQUEST["id"];
    $sql = "SELECT * FROM paciente WHERE id_paciente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result && $result->num_rows > 0) {
        $paciente = $result->fetch_assoc();
        $titulo = "Editar Paciente";
        $acao = "editar";
    } else {
        echo "<div class='alert alert-danger'>Paciente não encontrado.</div>";
        exit;
    }
    $stmt->close();
}
?>

<h1><?php echo $titulo; ?></h1>

<   <a href="../Projeto Fellipe/editar-paciente.php" method="post">
    <input type="hidden" name="acao" value="<?php echo $acao; ?>">
    <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente'] ?? ''; ?>">

    <div class="mb-3">
        <label for="nome_paciente">Nome</label>
        <input type="text" name="nome_paciente" class="form-control" value="<?php echo htmlspecialchars($paciente['nome_paciente'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
        <label for="data_nasc_paciente">Data de Nascimento</label>
        <input type="date" name="data_nasc_paciente" class="form-control" value="<?php echo htmlspecialchars($paciente['data_nasc_paciente'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
        <label for="cpf_paciente">CPF</label>
        <input type="text" name="cpf_paciente" class="form-control" value="<?php echo htmlspecialchars($paciente['cpf_paciente'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
        <label for="email_paciente">Email</label>
        <input type="email" name="email_paciente" class="form-control" value="<?php echo htmlspecialchars($paciente['email_paciente'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
        <label for="sexo_paciente">Sexo</label>
        <select name="sexo_paciente" class="form-control" required>
            <option value="M" <?php if (isset($paciente['sexo_paciente']) && $paciente['sexo_paciente'] == 'M') echo 'selected'; ?>>Masculino</option>
            <option value="F" <?php if (isset($paciente['sexo_paciente']) && $paciente['sexo_paciente'] == 'F') echo 'selected'; ?>>Feminino</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="endereco_paciente">Endereço</label>
        <input type="text" name="endereco_paciente" class="form-control" value="<?php echo htmlspecialchars($paciente['endereco_paciente'] ?? ''); ?>">
    </div>

    <div class="mb-3">
        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" class="form-control" value="<?php echo htmlspecialchars($paciente['telefone'] ?? ''); ?>">
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-success"><?php echo ($acao == "editar" ? "Atualizar" : "Cadastrar"); ?></button>
        <a href="?page=listar-paciente" class="btn btn-danger">Cancelar</a>
    </div>
</form>