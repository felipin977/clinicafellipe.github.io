<?php
// cadastrar-consulta.php
include_once("config.php");

$sqlMedicos = "SELECT id_medico, nome_medico, crm_medico, especialidade_medico FROM medico ORDER BY nome_medico";
$resMedicos = $conn->query($sqlMedicos);

$sqlPacientes = "SELECT id_paciente, nome_paciente, cpf_paciente FROM paciente ORDER BY nome_paciente";
$resPacientes = $conn->query($sqlPacientes);
?>

<h1>Cadastrar Consulta</h1>

<form action="?page=salvar-consulta" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="acao" value="cadastrar">
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="medico_id" class="form-label">Médico</label>
            <select class="form-select" name="medico_id" required>
                <option value="">Selecione um médico</option>
                <?php
                if ($resMedicos && $resMedicos->num_rows > 0) {
                    while ($medico = $resMedicos->fetch_assoc()) {
                        echo "<option value='{$medico['id_medico']}'>
                                {$medico['nome_medico']} - CRM: {$medico['crm_medico']} 
                                ({$medico['especialidade_medico']})
                              </option>";
                    }
                }
                ?>
            </select>
            <div class="invalid-feedback">
                Por favor, selecione um médico.
            </div>
        </div>
        
        <div class="col-md-6">
            <label for="paciente_id" class="form-label">Paciente</label>
            <select class="form-select" name="paciente_id" required>
                <option value="">Selecione um paciente</option>
                <?php
                if ($resPacientes && $resPacientes->num_rows > 0) {
                    while ($paciente = $resPacientes->fetch_assoc()) {
                        echo "<option value='{$paciente['id_paciente']}'>
                                {$paciente['nome_paciente']} - CPF: {$paciente['cpf_paciente']}
                              </option>";
                    }
                }
                ?>
            </select>
            <div class="invalid-feedback">
                Por favor, selecione um paciente.
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="data_consulta" class="form-label">Data da Consulta</label>
            <input type="date" class="form-control" name="data_consulta" min="<?php echo date('Y-m-d'); ?>" required>
            <div class="invalid-feedback">
                Por favor, selecione uma data válida.
            </div>
        </div>
        
        <div class="col-md-6">
            <label for="hora_consulta" class="form-label">Hora da Consulta</label>
            <input type="time" class="form-control" name="hora_consulta" required>
            <div class="invalid-feedback">
                Por favor, selecione um horário válido.
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="descricao_consulta" class="form-label">Descrição da Consulta</label>
        <textarea class="form-control" name="descricao_consulta" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="?page=listar-consulta" class="btn btn-secondary">Voltar</a>
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
