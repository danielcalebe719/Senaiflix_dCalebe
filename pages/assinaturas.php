<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.btn-editar, .btn-detalhes').click(function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var targetModal = $(this).data('target');

        $.ajax({
            type: 'POST',
            url: 'pages/consultaAssinaturas.php',
            dataType: 'json',
            data: { id: id },
            success: function(response) {
                if (response.error) {
                    console.error(response.error);
                } else {
                    // Populating the Edit Modal
                    // Populating the Edit Modal
                if (targetModal === '#modalEditarassinatura') {
                    $('#Editarid').val(response.id);
                    $('#Editarid_cliente').val(response.id_cliente);
                    $('#Editarplano').val(response.plano);
                    $('#Editardata_inicio').val(response.data_inicio);
                    $('#Editardata_fim').val(response.data_fim);
                    $('#Editardata_cadastro').val(response.data_cadastro);
                    $('#Editardata_atualizacao').val(response.data_atualizacao);
                    $('#Editarstatus').val(response.status);
                }
                    // Populating the Details Modal
                    else if (targetModal === '#modalDetalhesassinatura') {
                        $('#Detalhesid').val(response.id);
                        $('#Detalhesid_cliente').val(response.id_cliente);
                        $('#Detalhesplano').val(response.plano);
                        $('#Detalhesdata_inicio').val(response.data_inicio);
                        $('#Detalhesdata_fim').val(response.data_fim);
                        $('#Detalhesdata_cadastro').val(response.data_cadastro);
                        $('#Detalhesdata_atualizacao').val(response.data_atualizacao);
                        $('#Detalhesstatus').val(response.Status(status));
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
$conn = new mysqli($servername, $username, $password, $dbname);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    switch ($acao) {
        case 'adicionar':
            $id_cliente = $_POST['id_cliente'];
            $data_fim = $_POST['data_fim'];
            $data_inicio = $_POST['data_inicio'];
            $plano = $_POST['plano'];
            $data_cadastro = date('Y-m-d');
            $status = $_POST['status'];
            $queryAdicao = "INSERT INTO assinaturas (id_cliente, data_fim, data_inicio, plano, data_cadastro, data_atualizacao, status) 
                VALUES ('$id_cliente', '$data_fim', '$data_inicio', '$plano', '$data_cadastro', NOW(), '$status')";
            $result = mysqli_query($conn, $queryAdicao);
            break;
        case 'editar':
            $id = $_POST['Editarid'];
            $data_fim = $_POST['data_fim'];
            $data_inicio = $_POST['data_inicio'];
            $plano = $_POST['plano'];
            $data_atualizacao = date('Y-m-d');
            $status = $_POST['status'];

            $queryEdicao = "UPDATE assinaturas SET
                data_fim = '$data_fim', 
                data_inicio = '$data_inicio', 
                plano = '$plano', 
                status = '$status', 
                data_atualizacao = NOW() 
                WHERE id = '$id'";
            $result = mysqli_query($conn, $queryEdicao);
            break;
        case 'apagar':
            $id = $_POST['id'];
            $queryApagar = "DELETE FROM assinaturas WHERE id = '$id'";
            $result = mysqli_query($conn, $queryApagar);
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
                    <h6 class="m-0 font-weight-bold text-white">Assinaturas</h6>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAdicionarassinatura">Adicionar assinatura</button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>ID do Cliente</th>
                                <th>Email do Cliente</th>
                                <th>Data de Início</th>
                                <th>Data de Fim</th>
                                <th>Plano</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("conexao.php");
                            include("funcoes.php");
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            $queryListar = "SELECT a.id, a.id_cliente, c.email, a.data_inicio, a.data_fim, a.plano, a.status 
                            FROM assinaturas a
                            INNER JOIN clientes c ON a.id_cliente = c.id ORDER BY a.id";            
                            $resultado = mysqli_query($conn, $queryListar);
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["id_cliente"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . FormatDate($row["data_inicio"]) . "</td>";
                                echo "<td>" . FormatDate($row["data_fim"] ). "</td>";
                                echo "<td>" . $row["plano"] . "</td>";
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
                                        <button class='btn-editar btn btn-danger btn-md w-100' type='button' data-id='" . $row["id"] . "' data-toggle='modal' data-target='#modalEditarassinatura'>Editar</button>
                                    </div>
                                    <div class='col-sm-4'>
                                        <button class='btn-detalhes btn btn-info btn-md w-100' type='button' data-id='" . $row["id"] . "' data-toggle='modal' data-target='#modalDetalhesassinatura'>Detalhes</button>
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



<!-- Modal para Adicionar assinatura -->
<div class="modal fade" id="modalAdicionarassinatura" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarassinaturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarassinaturaLabel">Adicionar assinatura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="acao" value="adicionar">
                    <select name="id_cliente" id="id_cliente" class="form-control" required>
    <option value="">Selecione o Cliente</option>
            <?php
            $queryClientes = "SELECT id, email FROM clientes";
            $resultadoClientes = mysqli_query($conn, $queryClientes);
            while ($cliente = mysqli_fetch_assoc($resultadoClientes)) {
                echo "<option value='" . $cliente['id'] . "'>\n";
                echo "    <strong>Email:</strong> " . $cliente['email']. " |<br>\n";
                echo "    <strong>ID:</strong> " . $cliente['id']. "<br>\n";
                echo "</option>\n";
                
            }
            ?>
</select>
                    <div class="form-group">
                        <label for="data_fim">Data de Fim:</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" required>
                    </div>
                    <div class="form-group">
                        <label for="data_inicio">Data de Início:</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="plano">Plano:</label>
                        <input type="text" class="form-control" id="plano" name="plano" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status"  class="form-control">
                            <option  class="form-control" value="1">Ativo</option>
                            <option  class="form-control" value="0">Inativo</option>
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
<!-- Modal para Editar assinatura -->
<div class="modal fade" id="modalEditarassinatura" tabindex="-1" role="dialog" aria-labelledby="modalEditarassinaturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarassinaturaLabel">Editar assinatura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" id="Editarid" name="Editarid">
                    <div class="form-group">
                        <label for="Editarid_cliente">ID do Cliente:</label>
                        <input type="text" class="form-control" id="Editarid_cliente" name="id_cliente" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Editardata_fim">Data de Fim:</label>
                        <input type="date" class="form-control" id="Editardata_fim" name="data_fim" required>
                    </div>
                    <div class="form-group">
                        <label for="Editardata_inicio">Data de Início:</label>
                        <input type="date" class="form-control" id="Editardata_inicio" name="data_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarplano">Plano:</label>
                        <input type="text" class="form-control" id="Editarplano" name="plano" required>
                    </div>
                    <div class="form-group">
                        <label for="Editarstatus">Status:</label>
                        <select name="status" id="Editarstatus" class="form-control">
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Editardata_cadastro">Data de Cadastro:</label>
                        <input type="text" class="form-control" id="Editardata_cadastro" name="data_cadastro" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Editardata_atualizacao">Data de Início:</label>
                        <input type="text" class="form-control" id="Editardata_atualizacao" name="data_atualizacao" readonly>
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


<!-- Modal para Detalhes do assinatura -->
<div class="modal fade" id="modalDetalhesassinatura" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesassinaturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetalhesassinaturaLabel">Detalhes do assinatura</h5>
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
                        <label for="Detalhesid_cliente">ID do Cliente:</label>
                        <input type="text" class="form-control" id="Detalhesid_cliente" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesdata_fim">Data de Fim:</label>
                        <input type="text" class="form-control" id="Detalhesdata_fim" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesdata_inicio">Data de Início:</label>
                        <input type="text" class="form-control" id="Detalhesdata_inicio" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesplano">Plano:</label>
                        <input type="text" class="form-control" id="Detalhesplano" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesstatus">Status:</label>
                        <input type="text" class="form-control" id="Detalhesstatus" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesdata_cadastro">Data de Cadastro:</label>
                        <input type="text" class="form-control" id="Detalhesdata_cadastro" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Detalhesdata_atualizacao">Data de Atualização:</label>
                        <input type="text" class="form-control" id="Detalhesdata_atualizacao" readonly>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
