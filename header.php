<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar navbar-dark bg-dark">
        <a class="navbar-brand text-danger" href="#">SenaiFlix Administração</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?pagina=clientes">Clientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?pagina=filmes">Filmes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?pagina=assinaturas">Assinaturas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?pagina=usuarios">Usuários</a>
    </li>
    <li class="nav-item">
        <div class="container">
            <a href="?sair=true" class="btn btn-danger">Sair</a>
        </div>
    </li>


    
</ul>
<div class="text-white d d-flex justify-content-end">
            <h2>Olá <?php echo  "<strong class='text-danger'>".($_SESSION['usuario'])."</strong>" ?></h2>
        </div>
        </div>
    </nav>
    
</header>
