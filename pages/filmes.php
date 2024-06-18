

<!-- Script JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script JavaScript -->
<script>
$(document).ready(function() {
    $('.btn-editar, .btn-detalhes').click(function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var targetModal = $(this).data('target');

        $.ajax({
            type: 'POST',
            url: 'pages/consultaFilmes.php',
            dataType: 'json',
            data: { id: id },
            success: function(response) {
                if (response.error) {
                    console.error(response.error);
                } else {
                    // Populating the Edit Modal
                    if (targetModal === '#modalEditarFilme') {
                        $('#Editarid').val(response.id);
                        $('#Editartitulo').val(response.titulo);
                        $('#Editarclassificacao').val(response.classificacao);
                        $('#Editardescricao').val(response.descricao);
                        $('#Editargenero').val(response.genero);
                        $('#Editarano_lancamento').val(response.ano_lancamento);
                        $('#Editarstatus').val(response.status);
                        $('#Editarvideo').val(response.video);
                        $('#Editarimagem').val(response.imagem);
                    } 
                    // Populating the Details Modal
                    else if (targetModal === '#modalDetalhesFilme') {
                        $('#Detalhesid').val(response.id);
                        $('#DetalhesTitulo').val(response.titulo);
                        $('#Detalhesclassificacao').val(response.classificacao);
                        $('#Detalhesdescricao').val(response.descricao);
                        $('#Detalhesgenero').val(response.genero);
                        $('#Detalhesano_lancamento').val(response.ano_lancamento);
                        $('#Detalhesstatus').val(response.Status(status));
                        $('#Detalhesvideo').val(response.video);
                        $('#Detalhesimagem').val(response.imagem);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                console.error("Response: " + xhr.responseText);
            }
        });
    });

    $('.btn-salvar').click(function(event) {
        event.preventDefault();
        var id = $(this).data('id');
    });
});



</script>


<style>
    .alert {
        display: none;
    }
</style>

<?php
include('conexao.php');
include("funcoes.php");
$conn = new mysqli($servername, $username, $password, $dbname);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    switch ($acao) {
        case 'adicionar':
            $titulo = $_POST['titulo'];
            $genero = $_POST['genero'];
            $video = $_POST['video'];
            
            $imagem = $_POST['imagem'];
            $descricao = $_POST['descricao'];
            $classificacao = $_POST['classificacao'];
            $ano_lancamento = $_POST['ano_lancamento'];
            $data_cadastro = date('d/m/Y');
            $data_atualizacao = date('d/m/Y');
            $status = $_POST['status'];
            $queryAdicao = mysqli_query($conn, "INSERT INTO filmes (video, imagem, titulo, genero, descricao, classificacao, ano_lancamento, data_cadastro, data_atualizacao, status) 
VALUES ('$video', '$imagem', '$titulo', '$genero', '$descricao', '$classificacao', '$ano_lancamento', NOW(), NOW(), '$status')");
            break;
        case 'editar':
            $id = $_POST['Editarid'];
            $titulo = $_POST['titulo'];
            $genero = $_POST['genero'];
            $descricao = $_POST['descricao'];
            $classificacao = $_POST['classificacao'];
            $ano_lancamento = $_POST['ano_lancamento'];
            $data_atualizacao = date('d/m/Y');
            $status = $_POST['status'];
            $imagem = $_POST['imagem'];
            $video = $_POST['video'];


            $queryEdicao = "UPDATE filmes SET 
                video = '$video',
                imagem = '$imagem',
                titulo = '$titulo', 
                genero = '$genero', 
                descricao = '$descricao', 
                classificacao = '$classificacao', 
                ano_lancamento = '$ano_lancamento', 
                status = '$status', 
                data_atualizacao = NOW() 
                WHERE id = '$id'";
            $result = mysqli_query($conn, $queryEdicao);
            break;
        case 'apagar':
            $id = $_POST['id'];
            $queryApagar = mysqli_query($conn, "DELETE FROM filmes WHERE id = '$id'");
            break;
        default:
            echo 'Nenhuma ação reconhecida';
    }
}
?>

<div class="container-fluid" id="container-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                    <h6 class="m-0 font-weight-bold text-white">Filmes</h6>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAdicionarFilme">Adicionar Filme</button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Gênero</th>
                                <th>Classificação</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("conexao.php");
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            $queryListar = "SELECT * FROM filmes";
                            $resultado = mysqli_query($conn, $queryListar);
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["titulo"] . "</td>";
                                echo "<td>" . $row["genero"] . "</td>";
                                echo "<td>" . $row["classificacao"] . "</td>";
                                echo "<td>" . Status( $row["status"] ). "</td>";
                                echo "<td>
                                <div class='row my-4'>
                                    <div class='col-sm-4'>
                                        <form method='post'>
                                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                                            <input type='hidden' name='acao' value='apagar'>
                                            <input class='btn btn-primary btn-md w-100' type='submit' value='Apagar'>
                                        </form>
                                    </div>
                                    <div class='col-sm-4'>
                                        <button class='btn-editar btn btn-danger btn-md w-100' type='button' data-id='" . $row["id"] . "' data-toggle='modal' data-target='#modalEditarFilme'>Editar</button>
                                    </div>
                                    <div class='col-sm-4'>
                                        <button class='btn-detalhes btn btn-info btn-md w-100' type='button' data-id='" . $row["id"] . "' data-toggle='modal' data-target='#modalDetalhesFilme'>Detalhes</button>
                                    </div>
                                </div>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal para Adicionar Filme -->
<div class="modal fade" id="modalAdicionarFilme" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarFilmeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarFilmeLabel">Adicionar Filme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="acao" value="adicionar">
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Gênero:</label>
                        <input type="text" class="form-control" id="genero" name="genero" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <textarea type="text" class="form-control" id="descricao" name="descricao" required rows="5">
                            </textarea>
                    </div>
                    <div class="form-group">
                        <label for="classificacao">Classificação:</label>
                        <input type="text" class="form-control" id="classificacao" name="classificacao" required>
                    </div>
                    <div class="form-group">
                        <label for="ano_lancamento">Ano de Lançamento:</label>
                        <input type="date" class="form-control" id="ano_lancamento" name="ano_lancamento" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" name="status" id="status">
                               <option class="form-control" value="1">Ativo</option>
                               <option class="form-control" value="0">Inativo</option>            
                        </select>
                  
                    </div>
                    <div class="form-group">
                        <label for="video">Video Link:</label>
                        <input type="text" class="form-control" id="video" name="video" required>
                    </div>
                    <div class="form-group">
                        <label for="imagem">Imagem Capa:</label>
                        <input type="text" class="form-control" id="imagem" name="imagem" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Filme -->
<div class="modal fade" id="modalEditarFilme" tabindex="-1" role="dialog" aria-labelledby="modalEditarFilmeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarFilmeLabel">Editar Filme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" id="Editarid" name="Editarid">
                    <div class="form-group">
                        <label for="Editartitulo">Título:</label>
                        <input type="text" class="form-control" id="Editartitulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="Editargenero">Gênero:</label>
                        <input type="text" class="form-control" id="Editargenero" name="genero" required>
                    </div>
                    <div class="form-group">
                        <label for="Editardescricao">Descrição:</label>
                        <textarea type="text" class="form-control" id="Editardescricao" name="descricao" required rows="5">
                            </textarea>
                    </div>
                    <div class="form-group">
                        <label for="Editarclassificacao">Classificação:</label>
                        <input type="text" class="form-control" id="Editarclassificacao" name="classificacao" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarano_lancamento">Ano de Lançamento:</label>
                        <input type="date" class="form-control" id="Editarano_lancamento" name="ano_lancamento" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarvideo">Video Link:</label>
                        <input type="text" class="form-control" id="Editarvideo" name="video" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarimagem">Imagem Capa:</label>
                        <input type="text" class="form-control" id="Editarimagem" name="imagem" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarstatus">Status:</label>
                        <select class="form-control" name="status" id="Editarstatus">
                               <option class="form-control" value="1">Ativo</option>
                               <option class="form-control" value="0">Inativo</option>            
                        </select>                  
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Detalhes do Filme -->
<div class="modal fade" id="modalDetalhesFilme" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesFilmeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetalhesFilmeLabel">Detalhes do Filme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Detalhesid">ID:</label>
                        <input type="text" class="form-control" id="Detalhesid" readonly>
                    </div>
                    <div class="form-group">
                        <label for="DetalhesTitulo">Título:</label>
                        <input type="text" class="form-control" id="DetalhesTitulo" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesgenero">Gênero:</label>
                        <input type="text" class="form-control" id="Detalhesgenero" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesdescricao">Descrição:</label>
                        <textarea type="text" class="form-control" id="Detalhesdescricao" readonly rows="5">
                            </textarea>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesclassificacao">Classificação:</label>
                        <input type="text" class="form-control" id="Detalhesclassificacao" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesano_lancamento">Ano de Lançamento:</label>
                        <input type="date" class="form-control" id="Detalhesano_lancamento" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesvideo">Video Link:</label>
                        <input type="text" class="form-control" id="Detalhesvideo" name="video" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesimagem">Imagem Capa:</label>
                        <input type="text" class="form-control" id="Detalhesimagem" name="imagem" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesstatus">Status:</label>
                        <select class="form-control" name="status" id="Detalhesstatus">
                               <option class="form-control" value="1">Ativo</option>
                               <option class="form-control" value="0">Inativo</option>            
                        </select>                  
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
