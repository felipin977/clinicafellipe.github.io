<?php
// Conexão com o banco de dados
$servername = "localhost"; // ou seu servidor MySQL
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
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Validando a senha (por segurança, vamos criptografar a senha)
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparando a consulta SQL para inserir o usuário
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo_usuario) 
            VALUES ('$nome', '$email', '$senha_hash', '$tipo_usuario')";

    // Executando a consulta
    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    // Fechando a conexão
    $conn->close();
}
?>
