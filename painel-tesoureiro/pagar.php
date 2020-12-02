<?php 
$pag = "pagar";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'tesoureiro'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-info btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Nova Conta</a>
    <a type="button" class="btn-info btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>
    
</div>



<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Arquivo</th>
                        
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM contas_pagar where pago != 'Sim' order by id desc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $descricao = $res[$i]['descricao'];
                  $valor = $res[$i]['valor'];
                  $vencimento = $res[$i]['data_venc'];

                  $arquivo = $res[$i]['arquivo'];
                  $id = $res[$i]['id'];

                  $valor = number_format($valor, 2, ',', '.');
                  $vencimento = implode('/', array_reverse(explode('-', $vencimento)));

                  ?>


                  <tr>
                    <td><?php echo $descricao ?></td>
                    <td><?php echo $valor ?></td>
                    <td><?php echo $vencimento ?></td>

                    <td><?php if($arquivo != "sem-foto.jpg"){
                        echo '<a href="../img/contas/'.$arquivo.'"  target="_blank" title="Ver Arquivo"> Ver Arquivo </a>';
                    }  ?></td>


                    <td>
                       <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
                       <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>

                       <a href="index.php?pag=<?php echo $pag ?>&funcao=baixar&id=<?php echo $id ?>" class='text-success mr-1' title='Confirmar Pagamento'><i class='far fa-check-square'></i></a>


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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM contas_pagar where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $descricao2 = $res[0]['descricao'];
                    $vencimento2 = $res[0]['data_venc'];
                    $valor2 = $res[0]['valor'];
                    $arquivo2 = $res[0]['arquivo'];



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

                   <div class="row">
                    <div class="col-md-6">
                     <div class="form-group">
                        <label >Descrição</label>
                        <input value="<?php echo @$descricao2 ?>" type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição da Conta">
                    </div>


                    <div class="form-group">
                        <label >Valor</label>
                        <input value="<?php echo @$valor2 ?>" type="text" class="form-control" id="valor" name="valor" placeholder="Valor da Conta">
                    </div>

                    <div class="form-group">
                        <label >Data de Vencimento</label>
                        <input value="<?php echo @$vencimento2 ?>" type="date" class="form-control" id="vencimento" name="vencimento">
                    </div>
                </div>

                <div class="col-md-6">


                    <div class="form-group">
                        <label >Imagem</label>
                        <input type="file" value="<?php echo @$arquivo2 ?>"  class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
                    </div>

                    <div id="divImgConta">
                        <?php if(@$foto2 != ""){ ?>
                            <img src="../img/contas/<?php echo $arquivo2 ?>" width="200" height="200" id="target">
                        <?php  }else{ ?>
                            <img src="../img/contas/sem-foto.jpg" width="200" height="200" id="target">
                        <?php } ?>
                    </div>

                </div>
            </div>






            <small>
                <div id="mensagem">

                </div>
            </small> 

        </div>



        <div class="modal-footer">



            <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
            <input value="<?php echo @$cpf2 ?>" type="hidden" name="antigo" id="antigo">
            <input value="<?php echo @$email2 ?>" type="hidden" name="antigo2" id="antigo2">

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

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>





<div class="modal" id="modal-baixar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Baixar Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Confirmar este Pagamento?</p>

                <div align="center" id="mensagem_baixar" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-baixar">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-baixar" name="btn-baixar" class="btn btn-success">Baixar</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Professor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'endereco') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM professores where id = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $nome3 = $res[0]['nome'];
                    $cpf3 = $res[0]['cpf'];
                    $telefone3 = $res[0]['telefone'];
                    $email3 = $res[0]['email'];
                    $endereco3 = $res[0]['endereco'];
                    $foto3 = $res[0]['foto'];
                    
                } 


                ?>

                <span><b>Nome: </b> <i><?php echo $nome3 ?></i><br>
                    <span><b>Telefone: </b> <i><?php echo $telefone3 ?></i> <span class="ml-4"><b>CPF: </b> <i><?php echo $cpf3 ?></i><br>
                        <span><b>Email: </b> <i><?php echo $email3 ?><br>
                            <span><b>Endereço: </b> <i><?php echo $endereco3 ?><br>

                                <div class="mt-2" align="center">
                                    <img src="../img/professores/<?php echo $foto3 ?>" width="250px">
                                </div>

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

                if (@$_GET["funcao"] != null && @$_GET["funcao"] == "baixar") {
                    echo "<script>$('#modal-baixar').modal('show');</script>";
                }

                ?>




                <!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
                <script type="text/javascript">
                    $("#form").submit(function () {
                        var pag = "<?=$pag?>";
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
                    window.location = "index.php?pag="+pag;

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
                                        window.location = "index.php?pag=" + pag;
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


                        var arquivo = file['name'];
                        resultado = arquivo.split(".", 2);
        //console.log(resultado[1]);

        if(resultado[1] === 'pdf'){
            $('#target').attr('src', "../img/contas/pdf.png");
            return;
        }


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







                <!--AJAX PARA EXCLUSÃO DOS DADOS -->
                <script type="text/javascript">
                    $(document).ready(function () {
                        var pag = "<?=$pag?>";
                        $('#btn-baixar').click(function (event) {
                            event.preventDefault();

                            $.ajax({
                                url: pag + "/baixar.php",
                                method: "post",
                                data: $('form').serialize(),
                                dataType: "text",
                                success: function (mensagem) {

                                    if (mensagem.trim() === 'Baixado com Sucesso!') {


                                        $('#btn-cancelar-baixar').click();
                                        window.location = "index.php?pag=" + pag;
                                    }

                                    $('#mensagem_baixar').text(mensagem)



                                },

                            })
                        })
                    })
                </script>

