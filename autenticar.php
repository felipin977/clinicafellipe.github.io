<?php
// Conexão com o banco de dados
$servername = "localhost"; // ou o seu servidor de banco de dados
$username = "root"; // seu usuário do banco de dados
$password = ""; // sua senha do banco de dados
$dbname = "clinica"; // nome do seu banco de dados

// Criando conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verificando se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Preparando a consulta SQL para verificar o usuário
    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    // Verificando se o usuário existe
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Verificando se a senha é válida
        if (password_verify($senha, $usuario['senha'])) {
            // Inicia a sessão e redireciona o usuário
            session_start();
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            // Redirecionar para a página principal após login
            header("Location: painel.php"); // ou a página que você deseja após o login
            exit();
        } else {
            // Senha incorreta, redireciona de volta com erro
            header("Location: login.php?erro=1");
            exit();
        }
    } else {
        // E-mail não encontrado, redireciona de volta com erro
        header("Location: login.php?erro=1");
        exit();
    }
}

$conn->close();
?>
