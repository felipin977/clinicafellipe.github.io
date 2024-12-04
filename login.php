
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Link para o Bootstrap (versão mais recente) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 8px;
            box-shadow: 10 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
        }
        .btn {
            border-radius: 30px;
            padding: 12px 20px;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .lead {
            color: #6c757d;
            font-size: 1.25rem;
        }
        .container {
            margin-top: 10px;
        }
    </style>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clínica Médica</title>
    <!-- Link para o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .btn {
            border-radius: 30px;
            padding: 12px 20px;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .card-title {
            color: #343a40;
        }
        .card-text {
            color: #6c757d;
        }
        .container {
            margin-top: 50px;
        }
        .row {
            display: flex;
            justify-content: center;
        }
        .col-md-4 {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4 text-primary">Bem-vindo ao Sistema de Clínica Médica</h1>
    <p class="lead text-center mb-5">Selecione uma opção no menu abaixo para começar.</p>

    <div class="row">
        <!-- Cartão para Médicos -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Médicos</h5>
                    <p class="card-text">Gerencie o cadastro de médicos da clínica.</p>
                    <a href="../Projeto Fellipe/listar-medico.php" class="btn btn-primary">Gerenciar Médicos</a>
                </div>
            </div>
        </div>

        <!-- Cartão para Pacientes -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Pacientes</h5>
                    <p class="card-text">Gerencie o cadastro de pacientes.</p>
                    <a href="../Projeto Fellipe/listar-paciente.php" class="btn btn-primary">Gerenciar Pacientes</a>
                </div>
            </div>
        </div>

        <!-- Cartão para Consultas -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Consultas</h5>
                    <p class="card-text">Agende e gerencie consultas.</p>
                    <a href="../Projeto Fellipe/listar-consulta.php" class="btn btn-primary">Gerenciar Consultas</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para o Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

       
