<?php
// editar-pagamento.php
include_once("config.php");

$id_pagamento = $_GET['id'] ?? null;

if (!$id_pagamento) {
    header("Location: ?page=listar-pagamento&erro=Pagamento não encontrado");
    exit;
}

$sqlPagamento = "SELECT * FROM pagamento WHERE id_pagamento = ?";
$stmtPagamento = $conn->prepare($sqlPagamento);
$stmtPagamento->bind_param("i", $id_pagamento);
$stmtPagamento->execute();
$resultPagamento = $stmtPagamento->get_result();
$pagamento = $resultPagamento->fetch_assoc();

if (!$pagamento) {
    header("Location: ?page=listar-pagamento&erro=Pagamento não encontrado");
    exit;
}

$sqlPacientes = "SELECT id_paciente, nome_paciente FROM paciente ORDER BY nome_paciente";
$resPacientes = $conn->query($sqlPacientes);
?>

<h1>Editar Pagamento</h1>

<form action="?page=salvar-pagamento" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id_pagamento" value="<?php echo $pagamento['id_pagamento']; ?>">

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="paciente_id" class="form-label">Paciente</label>
            <select class="form-select" name="paciente_id" required>
                <?php
                if ($resPacientes && $resPacientes->num_rows > 0) {
                    while ($paciente = $resPacientes->fetch_assoc()) {
                        $selected = $paciente['id_paciente'] == $pagamento['paciente_id'] ? "selected" : "";
                        echo "<option value='{$paciente['id_paciente']}' $selected>
                                {$paciente['nome_paciente']}
                              </option>";
                    }
                }
                ?>
            </select>
            <div class="invalid-feedback">
                Por favor, selecione um paciente.
            </div>
        </div>

        <div class="col-md-6">
            <label for="valor_pagamento" class="form-label">Valor do Pagamento</label>
            <input type="number" step="0.01" class="form-control" name="valor_pagamento" value="<?php echo $pagamento['valor_pagamento']; ?>" required>
            <div class="invalid-feedback">
                Por favor, insira um valor válido.
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="data_pagamento" class="form-label">Data do Pagamento</label>
        <input type="date" class="form-control" name="data_pagamento" value="<?php echo $pagamento['data_pagamento']; ?>" required>
        <div class="invalid-feedback">
            Por favor, selecione uma data válida.
        </div>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="?page=listar-pagamento" class="btn btn-secondary">Voltar</a>
    </div>
</form>

<script>
// Validação do formulário
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>

<?php
$conn->close();
?>