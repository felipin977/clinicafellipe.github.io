<?php
// cadastrar-pagamento.php
include_once("config.php");

$sqlPacientes = "SELECT id_paciente, nome_paciente FROM paciente ORDER BY nome_paciente";
$resPacientes = $conn->query($sqlPacientes);
?>

<h1>Cadastrar Pagamento</h1>

<form action="?page=salvar-pagamento" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="acao" value="cadastrar">
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="paciente_id" class="form-label">Paciente</label>
            <select class="form-select" name="paciente_id" required>
                <option value="">Selecione um paciente</option>
                <?php
                if ($resPacientes && $resPacientes->num_rows > 0) {
                    while ($paciente = $resPacientes->fetch_assoc()) {
                        echo "<option value='{$paciente['id_paciente']}'>
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
            <input type="number" step="0.01" class="form-control" name="valor_pagamento" required>
            <div class="invalid-feedback">
                Por favor, insira um valor válido.
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="data_pagamento" class="form-label">Data do Pagamento</label>
        <input type="date" class="form-control" name="data_pagamento" required>
        <div class="invalid-feedback">
            Por favor, selecione uma data válida.
        </div>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Cadastrar</button>
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