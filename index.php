<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: login.php");
    exit();
}

// Função para encerrar a sessão
function logout() {
    // Encerrar a sessão
    session_destroy();
    // Redirecionar para a página de login
    header("Location: index.php?pagina=login");
    exit();
}

// Verificar se o botão de sair foi clicado
if (isset($_GET['sair'])) {
    logout();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minha Página</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    
    <style>
        .row {
            justify-content: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>



    <div class="container-fluid my-5">
        <?php
        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'home';
        $pagePath = "pages/{$pagina}.php";

        if (file_exists($pagePath)) {
            include $pagePath;
        } else {
            echo "<div class='alert alert-danger'>Página não encontrada.</div>";
        }
        ?>
    </div>

    <?php include 'footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function(){
            function limparFormularioCEP(){
                $('#endereco').val("");
                $('#bairro').val("");
                $('#cidade').val("");
                $('#estado').val("");
            }

            $("#cep").blur(function(){
                var cep = $(this).val().replace(/\D/g, '');
                if (cep !== "") {
                    var validacep = /^[0-9]{8}$/;
                    if (validacep.test(cep)) {
                        $('#endereco').val("...");
                        $('#bairro').val("...");
                        $('#cidade').val("...");
                        $('#estado').val("...");
                        
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                $('#endereco').val(dados.logradouro);
                                $('#bairro').val(dados.bairro);
                                $('#cidade').val(dados.localidade);
                                $('#estado').val(dados.uf);
                            } else {
                                limparFormularioCEP();
                                alert("CEP não encontrado.");
                            }
                        });
                    } else {
                        limparFormularioCEP();
                        alert("Formato de CEP inválido.");
                    }
                } else {
                    limparFormularioCEP();
                }
            });
        });

        $(document).ready(function(){
            function limparFormularioCEPEdita(){
                $('#Editarendereco').val("");
                $('#Editarbairro').val("");
                $('#Editarcidade').val("");
                $('#Editarestado').val("");
            }

            $("#Editarcep").blur(function(){
                var cep = $(this).val().replace(/\D/g, '');
                if (cep !== "") {
                    var validacep = /^[0-9]{8}$/;
                    if (validacep.test(cep)) {
                        $('#Editarendereco').val("...");
                        $('#Editarbairro').val("...");
                        $('#Editarcidade').val("...");
                        $('#Editarestado').val("...");
                        
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                $('#Editarendereco').val(dados.logradouro);
                                $('#Editarbairro').val(dados.bairro);
                                $('#Editarcidade').val(dados.localidade);
                                $('#Editarestado').val(dados.uf);
                            } else {
                                limparFormularioCEPEdita();
                                alert("CEP não encontrado.");
                            }
                        });
                    } else {
                        limparFormularioCEPEdita();
                        alert("Formato de CEP inválido.");
                    }
                } else {
                    limparFormularioCEPEdita();
                }
            });
        });
</script>

</body>
</html>
