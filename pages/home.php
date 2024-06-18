<div class="jumbotron  bg-dark text-white">
    <h1 class="display-4">Bem-vindo ao DashBoard SenaiFlix!</h1>
    <p class="lead">Esta é a página inicial do meu site.</p>
    <hr class="my-4">
    <p>Utilize a navegação acima para explorar outras páginas.</p>
</div>
<?php
// Incluindo arquivo de conexão com o banco de dados
require_once('conexao.php');

// Consulta SQL para selecionar os filmes
$sql = "SELECT * FROM filmes";
$result = $conn->query($sql);

// Fechando a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">



<div class="container mt-5">
    <h1 class="text-center text-danger mb-4">Filmes</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $titulo = $row['titulo'];
                $descricao = $row['descricao'];
                $video = $row['video'];
                $imagem = $row['imagem'];
                ?>
                <div class="col-md-3">
                    <div class="card bg-dark text-white mb-4 box-shadow-mt-4 shadow-lg p-3 mb-5 bg-light rounded card-img">
                      
                        <?php if (!empty($imagem)) { ?>

                            <img src="<?php echo $imagem; ?>" class="card-img-top" alt="<?php echo $titulo; ?> " style="max-height: 360px;">
                        <?php } else { ?>
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" src="<?php echo $video; ?>" controls></video>
                            </div>
                        <?php } ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $titulo; ?></h5>
                            <p class="card-text">
                                <span class="short-text"><?php echo substr($descricao, 0, 100); ?></span>
                                <?php if (strlen($descricao) > 100) { ?>
                                    <button class="btn btn-link read-more-btn">Ler mais</button>
                                    <span class="full-text" style="display: none;"><?php echo $descricao; ?></span>
                                <?php } ?>
                            </p>
                            <a href="pages/incorporacao.php?video=<?php echo $video; ?>&titulo=<?php echo $titulo; ?>" class="btn btn-danger btn-block">Assistir</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center text-white'>Nenhum filme disponível.</p>";
        }
        ?>
    </div>
</div><script>
    document.addEventListener('DOMContentLoaded', () => {
        const readMoreButtons = document.querySelectorAll('.read-more-btn');

        readMoreButtons.forEach(button => {
            button.addEventListener('click', () => {
                const parent = button.parentNode;
                const shortText = parent.querySelector('.short-text');
                const fullText = parent.querySelector('.full-text');

                shortText.style.display = 'none';
                fullText.style.display = 'inline';
                button.style.display = 'none';
            });
        });
    });
</script>


<!-- Bootstrap JS (Optional, for certain features like validation) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>