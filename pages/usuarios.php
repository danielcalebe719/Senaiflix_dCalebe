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
            url: 'pages/consultaUsuarios.php',
            dataType: 'json',
            data: { id: id },
            success: function(response) {
                if (response.error) {
                    console.error(response.error);
                } else {
                    // Populating the Edit Modal
                    if (targetModal === '#modalEditarUsuario') {
                        $('#Editarid').val(response.id);
                        $('#Editarnome').val(response.nome);
                        $('#Editarusuario').val(response.usuario);
                        $('#Editarsenha').val(response.senha);
                        $('#Editaremail').val(response.email);
                        $('#Editarstatus').val(response.status);

                    } 
                    // Populating the Details Modal
                    else if (targetModal === '#modalDetalhesUsuario') {
                        $('#Detalhesid').val(response.id);
                        $('#Detalhesnome').val(response.nome);
                        $('#Detalhesusuario').val(response.usuario);
                        $('#Detalhessenha').val(response.senha);
                        $('#Detalhesstatus').val(response.status);
                        $('#Detalhesemail').val(response.email);

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
            url: 'pages/consultaUsuarios.php',
            dataType: 'json',
            data: { id: id },
            success: function(response) {
                if (response.error) {
                    console.error(response.error);
                } else {
                    // Populating the Edit Modal
                    if (targetModal === '#modalEditarUsuario') {
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
                    else if (targetModal === '#modalDetalhesUsuario') {
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
            $nome = $_POST['nome'];
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            $email = $_POST['email'];
            $status = $_POST['status'];
            
            $queryAdicao = mysqli_query($conn, "INSERT INTO usuarios (nome, usuario, senha, email, data_cadastro, data_atualizacao, status) 
VALUES ('$nome', '$usuario', '$senha', '$email', NOW(), NOW(), '$status')");
            if ($queryAdicao) {
              
            } else {
                echo "Erro ao adicionar usuário: " . mysqli_error($conn);
            }
            break;

        case 'editar':
            $id = $_POST['Editarid'];
            $nome = $_POST['nome'];
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            $email = $_POST['email'];
            $status = $_POST['status'];

            $queryEdicao = "UPDATE usuarios SET 
                nome = '$nome',
                usuario = '$usuario',
                senha = '$senha',
                email = '$email',
                status = '$status',
                data_atualizacao = NOW() 
                WHERE id = '$id'";
            $result = mysqli_query($conn, $queryEdicao);
            if ($result) {
                echo "Usuário atualizado com sucesso.";
            } else {
                echo "Erro ao atualizar usuário: " . mysqli_error($conn);
            }
            break;

        case 'apagar':
            $id = $_POST['id'];
            $queryApagar = mysqli_query($conn, "DELETE FROM usuarios WHERE id = '$id'");
            if ($queryApagar) {
                echo "Usuário deletado com sucesso.";
            } else {
                echo "Erro ao deletar usuário: " . mysqli_error($conn);
            }
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
                    <h6 class="m-0 font-weight-bold text-white">Usuarios</h6>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAdicionarUsuario">Adicionar Usuario</button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Usuário</th>
                            <th>Email</th>
                            <th>Status</th>
                
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("conexao.php");
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            $queryListar = "SELECT * FROM usuarios";
                            $resultado = mysqli_query($conn, $queryListar);
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["nome"] . "</td>";
                                echo "<td>" . $row["usuario"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
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
                                        <button class='btn-editar btn btn-danger btn-md w-100' type='button' data-id='" . $row["id"] . "' data-toggle='modal' data-target='#modalEditarUsuario'>Editar</button>
                                    </div>
                                    <div class='col-sm-4'>
                                        <button class='btn-detalhes btn btn-info btn-md w-100' type='button' data-id='" . $row["id"] . "' data-toggle='modal' data-target='#modalDetalhesUsuario'>Detalhes</button>
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


<!-- Modal para Adicionar Usuário -->
<div class="modal fade" id="modalAdicionarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarUsuarioLabel">Adicionar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="acao" value="adicionar">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="usuario">Usuário:</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
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

<!-- Modal para Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" id="Editarid" name="Editarid">
                    <div class="form-group">
                        <label for="Editarnome">Nome:</label>
                        <input type="text" class="form-control" id="Editarnome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarusuario">Usuário:</label>
                        <input type="text" class="form-control" id="Editarusuario" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarsenha">Senha:</label>
                        <input type="password" class="form-control" id="Editarsenha" name="senha">
                    </div>
                    <div class="form-group">
                        <label for="Editaremail">Email:</label>
                        <input type="email" class="form-control" id="Editaremail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarstatus">Status:</label>
                        <select class="form-control" name="status" id="Editarstatus">
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
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

<!-- Modal para Detalhes do Usuario -->
<div class="modal fade" id="modalDetalhesUsuario" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                <h5 class="modal-title" id="modalDetalhesUsuarioLabel">Detalhes do Usuário</h5>
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
                        <label for="Detalhesnome">Nome:</label>
                        <input type="text" class="form-control" id="Detalhesnome" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesusuario">Usuário:</label>
                        <input type="text" class="form-control" id="Detalhesusuario" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhessenha">Senha:</label>
                        <input type="text" class="form-control" id="Detalhessenha" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesemail">Email:</label>
                        <input type="text" class="form-control" id="Detalhesemail" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesstatus">Status:</label>
                        <input type="text" class="form-control" id="Detalhesstatus" readonly>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
