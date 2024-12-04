<h1>Cadastrar Médico</h1>
<p>Cadastro de médicos</p>

<?php
// Mensagens de sucesso/erro
if (isset($_GET['sucesso'])) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . $_GET['sucesso'] . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
}
if (isset($_GET['erro'])) {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" . $_GET['erro'] . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
}
?>

<form action="?page=salvar-medico" method="post">
    <input type="hidden" name="acao" value="cadastrar">

    <div class="mb-3">
        <label for="nome_medico">Nome</label>
        <input type="text" class="form-control" id="nome_medico" name="nome_medico" required>
    </div>
    <div class="mb-3">
        <label for="crm_medico">CRM</label>
        <input type="text" class="form-control" id="crm_medico" name="crm_medico" required>
    </div>
    <div class="mb-3">
        <label for="especialidade_medico">Especialidade</label>
        <input type="text" class="form-control" id="especialidade_medico" name="especialidade_medico" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-success">Cadastrar</button>
        <a href="?page=listar-medico" class="btn btn-danger">Cancelar</a>
    </div>
</form>