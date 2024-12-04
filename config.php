<?php
// Definição das constantes para conexão com o banco de dados
define('HOST', 'localhost');
define('USER', 'root');  // Substitua pelo seu usuário
define('PASS', '');      // Substitua pela sua senha
define('BASE', 'clinica'); // Substitua pelo nome do seu banco de dados

// Estabelecendo a conexão com o banco de dados
$conn = new mysqli(HOST, USER, PASS, BASE);

// Verificando se houve erro na conexão
if ($conn->connect_error) {
    // Logando o erro no servidor e enviando uma mensagem genérica para o usuário
    error_log("Erro de conexão com o banco de dados: " . $conn->connect_error); // Log do erro
    die("Erro ao conectar ao banco de dados. Tente novamente mais tarde."); // Mensagem amigável ao usuário
}
?>