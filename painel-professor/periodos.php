<?php 
$pag = "periodos";
require_once("../conexao.php"); 
$id_turma = $_GET['id'];
@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'professor'){
    echo "<script language='javascript'> window.location='../index.php' </script>";
    exit();
}


?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-info btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo&id=<?php echo $id_turma ?>">Novo Período</a>
    <a type="button" class="btn-info btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>
    
</div>



<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Período</th>
                        <th>Data Inicial</th>
                        <th>Data Final</th>
                        <th>Total Pontos</th>
                        <th>Minímo Média</th>
                        
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                   <?php 

                   $query = $pdo->query("SELECT * FROM periodos where turma = '$id_turma' order by id desc ");
                   $res = $query->fetchAll(PDO::FETCH_ASSOC);

                   for ($i=0; $i < count($res); $i++) { 
                      foreach ($res[$i] as $key => $value) {
                      }

                      $nome = $res[$i]['nome'];
                      $data_inicio = $res[$i]['data_inicio'];
                      $data_final = $res[$i]['data_final'];
                      $total_pontos = $res[$i]['total_pontos'];
                      $minimo_media = $res[$i]['minimo_media'];
                      
                       $data_inicio = implode('/', array_reverse(explode('-', $data_inicio)));
                        $data_final = implode('/', array_reverse(explode('-', $data_final)));
                      
                     
                      $id = $res[$i]['id'];


                      ?>


                      <tr>
                        <td><?php echo $nome ?></td>
                        <td><?php echo $data_inicio ?></td>
                        <td><?php echo $data_final ?></td>
                        <td><?php echo $total_pontos ?></td>
                        <td><?php echo $minimo_media ?></td>

                        <td>
                         <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id_periodo=<?php echo $id ?>&id=<?php echo $id_turma ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
                         <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id_periodo=<?php echo $id ?>&id=<?php echo $id_turma ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>

                         
                     </td>
                 </tr>
             <?php } ?>





         </tbody>
     </table>
 </div>
</div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id_periodo'];

                    $query = $pdo->query("SELECT * FROM periodos where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome2 = $res[0]['nome'];
                    $data_inicio2 = $res[0]['data_inicio'];
                    $data_final2 = $res[0]['data_final'];
                    $total_pontos2 = $res[0]['total_pontos'];
                    $minimo_media2 = $res[0]['minimo_media'];
                                        


                } else {
                    $titulo = "Inserir Registro";

                }


                ?>
                
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">

                    <div class="form-group">
                        <label >Nome</label>
                        <input value="<?php echo @$nome2 ?>" type="text" class="form-control" id="nome" name="nome" placeholder="1º Período, Bimestre, Semestre, etc">
                    </div>

                      <div class="form-group">
                        <label >Data Inicio</label>
                        <input value="<?php echo @$data_inicio2 ?>" type="date" class="form-control" id="data_inicio" name="data_inicio">
                    </div>

                      <div class="form-group">
                        <label >Data Final</label>
                        <input value="<?php echo @$data_final2 ?>" type="date" class="form-control" id="data_final" name="data_final">
                    </div>

                     <div class="form-group">
                        <label >Total Pontos</label>
                        <input value="<?php echo @$total_pontos2 ?>" type="number" class="form-control" id="total_pontos" name="total_pontos">
                    </div>

                     <div class="form-group">
                        <label >Minímo Média</label>
                        <input value="<?php echo @$minimo_media2 ?>" type="number" class="form-control" id="minimo_media" name="minimo_media">
                    </div>

                     

            <small>
                <div id="mensagem">

                </div>
            </small> 

        </div>



        <div class="modal-footer">



            <input value="<?php echo @$_GET['id_periodo'] ?>" type="hidden" name="txtid2" id="txtid2">
            <input value="<?php echo @$nome2 ?>" type="hidden" name="antigo" id="antigo">
            <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="turma" id="turma">
           

            <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>
</div>
</div>






<div class="modal" id="modal-deletar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Excluir este Registro?</p>

                <div align="center" id="mensagem_excluir" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id_periodo'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>




                <?php 

                if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
                    echo "<script>$('#modalDados').modal('show');</script>";
                }

                if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
                    echo "<script>$('#modalDados').modal('show');</script>";
                }

                if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
                    echo "<script>$('#modal-deletar').modal('show');</script>";
                }

             

                ?>




                <!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
                <script type="text/javascript">
                    $("#form").submit(function () {
                        var pag = "<?=$pag?>";
                        var idturma = "<?=$id_turma?>";
                        event.preventDefault();
                        var formData = new FormData(this);

                        $.ajax({
                            url: pag + "/inserir.php",
                            type: 'POST',
                            data: formData,

                            success: function (mensagem) {

                                $('#mensagem').removeClass()

                                if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pag="+pag+"&id="+idturma;

                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
                    });
                </script>





                <!--AJAX PARA EXCLUSÃO DOS DADOS -->
                <script type="text/javascript">
                    $(document).ready(function () {
                        var pag = "<?=$pag?>";
                        $('#btn-deletar').click(function (event) {
                            event.preventDefault();

                            $.ajax({
                                url: pag + "/excluir.php",
                                method: "post",
                                data: $('form').serialize(),
                                dataType: "text",
                                success: function (mensagem) {

                                    if (mensagem.trim() === 'Excluído com Sucesso!') {


                                        $('#btn-cancelar-excluir').click();
                                        window.location = "index.php?pag="+pag+"&id="+idturma;
                                    }

                                    $('#mensagem_excluir').text(mensagem)



                                },

                            })
                        })
                    })
                </script>



                <!--SCRIPT PARA CARREGAR IMAGEM -->
                <script type="text/javascript">

                    function carregarImg() {

                        var target = document.getElementById('target');
                        var file = document.querySelector("input[type=file]").files[0];
                        var reader = new FileReader();

                        reader.onloadend = function () {
                            target.src = reader.result;
                        };

                        if (file) {
                            reader.readAsDataURL(file);


                        } else {
                            target.src = "";
                        }
                    }

                </script>





                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#dataTable').dataTable({
                            "ordering": false
                        })

                    });
                </script>



