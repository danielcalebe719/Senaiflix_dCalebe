<?php
// Incluindo arquivo de conexão com o banco de dados
require_once('./pages/conexao.php');

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo os dados do formulário
    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $email = $_POST["email"];
    
    // Data atual
    $data_cadastro = date("Y-m-d H:i:s");

    // Criptografando a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparando a consulta SQL para inserir um novo usuário
    $sql = "INSERT INTO usuarios (nome, usuario, senha, email, data_cadastro) 
            VALUES ('$nome', '$usuario', '$senhaHash', '$email', '$data_cadastro')";

    // Executando a consulta
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Usuário cadastrado com sucesso');</script>";
        header("Location: login.php");
    } else {
        echo "<script>alert('Erro ao cadastrar usuário: " . $conn->error . "');</script>";
    }
}

// Fechando a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="card bg-dark text-white">
            <div class="card-header bg-danger text-white text-center">
                <h1 class="mb-0">Cadastro de Usuário</h1>
            </div>
            <div class="card-body">
                <form method="post" class="row g-3">
                    <div class="col-md-6">
                        <label for="inputNome" class="form-label">Nome</label>
                        <input type="text" class="form-control bg-dark text-white" id="inputNome" name="nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputUsuario" class="form-label">Nome de Usuário</label>
                        <input type="text" class="form-control bg-dark text-white" id="inputUsuario" name="usuario" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputSenha" class="form-label">Senha</label>
                        <input type="password" class="form-control bg-dark text-white" id="inputSenha" name="senha" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control bg-dark text-white" id="inputEmail" name="email" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger btn-lg btn-block">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional, for certain features like validation) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
