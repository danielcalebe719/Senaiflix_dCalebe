<?php
require_once('./pages/conexao.php');
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($senha, $row['senha'])) {

            session_start();

            $_SESSION['usuario'] = $usuario;

            header("Location: index.php");
            echo "<script>alert('Login bem-sucedido. Redirecionando para a página inicial...');</script>";
            exit();
        } else {

            echo "<script>alert('Usuário ou senha incorretos');</script>";
        }
    } else {

        echo "<script>alert('Usuário ou senha incorretos');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="card bg-dark text-white">
            <div class="card-header bg-danger text-white text-center">
                <h1 class="mb-0">Login</h1>
            </div>
            <div class="card-body">
                <form method="post" class="row g-3">
                    <div class="col-md-12">
                        <label for="inputUsuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control bg-dark text-white" id="inputUsuario" name="usuario" required>
                    </div>
                    <div class="col-md-12">
                        <label for="inputSenha" class="form-label">Senha</label>
                        <input type="password" class="form-control bg-dark text-white" id="inputSenha" name="senha" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger btn-lg btn-block">Entrar</button>
                        <a href="cadastro.php" class="btn btn-warning btn-lg btn-block">Cadastrar-se</a>
                    </div>
                    
                </form>
            </div>
        </div>
       
    </div>

    <!-- Bootstrap JS (Optional, for certain features like validation) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
