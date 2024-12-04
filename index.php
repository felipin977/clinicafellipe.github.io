
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clínica Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <style>
        /* Estilos para as mensagens de alerta */
        .alert {
            position: fixed; /* Fixa a posição do alerta */
            top: 10px; /* Distância do topo */
            right: 10px; /* Distância da direita */
            z-index: 1000; /* Garante que o alerta fique acima de outros elementos */
        }
    </style>

        <link rel="stylesheet" href="style.css">
</head>

<body>
<?php include 'navbar.php'; ?>


    <div class="container mt-5">
        <?php
        if (isset($_GET['sucesso'])) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>" . $_GET['sucesso'] .
                "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
        if (isset($_GET['erro'])) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" . $_GET['erro'] .
                "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }

        // Inclui o arquivo correspondente à página solicitada
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $file = $page . '.php';
            if (file_exists($file)) {
                include $file;
            } else {
                include 'home.php'; // Ou exiba uma página de erro 404
            }
        } else {
            include 'home.php'; // Página inicial padrão
        }
        ?>
    </div>


</body>
</html>