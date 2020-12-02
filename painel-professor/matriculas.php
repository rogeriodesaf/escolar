<?php 
$pag = "matriculas";
require_once("../conexao.php"); 

@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario'];
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'tesoureiro'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>



<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>CPF</th>
                        <th>Idade</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM alunos order by id desc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $nome = $res[$i]['nome'];
                  $telefone = $res[$i]['telefone'];
                  $email = $res[$i]['email'];
                  $endereco = $res[$i]['endereco'];
                  $cpf = $res[$i]['cpf'];
                  $foto = $res[$i]['foto'];
                  $id = $res[$i]['id'];
                  $data_nasc = $res[$i]['data_nascimento'];


                  $date1 = $data_nasc;
                  $date2 = date('Y-m-d');
                  $diff = abs(strtotime($date2) - strtotime($date1));
                  $idade = floor($diff / (365*60*60*24));
                  

                  ?>


                  <tr>
                    <td>
                        <a href="index.php?pag=<?php echo $pag ?>&funcao=matriculas&id=<?php echo $id ?>" title="Ver Matrículas" class="text-dark"><?php echo $nome ?></a>

                    </td>
                    <td><?php echo $telefone ?></td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $cpf ?></td>
                    <td><?php echo $idade ?></td>


                    <td>

                       <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Dados do Aluno'><i class='fas fa-home'></i></a>

                        <a href="index.php?pag=<?php echo $pag ?>&funcao=turmas&id=<?php echo $id ?>" class='text-primary mr-1' title='Ver Turmas'><i class='fas fa-book-open'></i></a>
                   </td>
               </tr>
           <?php } ?>





       </tbody>
   </table>
</div>
</div>
</div>



<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Aluno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'endereco') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM alunos where id = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $nome3 = $res[0]['nome'];
                    $cpf3 = $res[0]['cpf'];
                    $telefone3 = $res[0]['telefone'];
                    $email3 = $res[0]['email'];
                    $endereco3 = $res[0]['endereco'];
                    $foto3 = $res[0]['foto'];
                    $data_nasc3 = $res[0]['data_nascimento'];
                    $sexo3 = $res[0]['sexo'];
                    $responsavel3 = $res[0]['responsavel'];

                    $query_resp = $pdo->query("SELECT * FROM responsaveis where cpf = '$responsavel3' ");
                    $res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);
                    $nome_resp = $res_resp[0]['nome'];
                    $telefone_resp = $res_resp[0]['telefone'];
                    $email_resp = $res_resp[0]['email'];

                    $data_F = implode('/', array_reverse(explode('-', $data_nasc3)));
                    
                    //CALCULAR IDADE
                    $date1 = $data_nasc3;
                    $date2 = date('Y-m-d');
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $idade = floor($diff / (365*60*60*24));

                    
                } 


                ?>

                <div class="row">
                    <div class="col-md-7">
                        <span><b>Nome: </b> <i><?php echo $nome3 ?></i><br></span>
                        <span><b>Telefone: </b> <i><?php echo $telefone3 ?></i></span> <span class="ml-4"><b>CPF: </b> <i><?php echo $cpf3 ?></i><br>
                        </span><span><b>Email: </b> <i><?php echo $email3 ?><br></i></span>
                    </span><span><b>Data de Nascimento: </b> <i><?php echo $data_F ?><br></i></span>

                    <span><b>Sexo: </b> <i><?php echo $sexo3 ?></i> </span> <span class="ml-4"><b>Idade: </b> <i><?php echo $idade ?> Anos</i><br></span>

                    <span><b>Endereço: </b> <i><?php echo $endereco3 ?><br></i></span>

                    <?php if($responsavel3 != ""){ ?>
                        <p class="mt-2"><i><u>Dados do Responsável</i></u></p>

                        <span><b>Nome: </b> <i><?php echo $nome_resp ?></i><br></span>
                        <span><b>Telefone: </b> <i><?php echo $telefone_resp ?></i></span> <span class="ml-4"><b>CPF: </b> <i><?php echo $responsavel3 ?></i><br>
                        </span><span><b>Email: </b> <i><?php echo $email_resp ?><br></i></span>




                    <?php } ?>
                </div>

                <div class="col-md-5">

                    <img src="../img/alunos/<?php echo $foto3 ?>" width="100%">

                </div>


            </div>


        </div>

    </div>
</div>
</div>




<div class="modal" id="modal-turmas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Turmas do Aluno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'turmas') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM matriculas where aluno = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                   

                  for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                   $id_turma = $res[$i]['turma'];
                    $id_mat = $res[$i]['id'];


                    $query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
                    $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                    $disciplina = $res_2[0]['disciplina'];
                    $horario = $res_2[0]['horario'];
                    $dia = $res_2[0]['dia'];
                    $ano = $res_2[0]['ano'];
                  

                    $query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
                    $res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);
                    
                    $nome_disc = $res_resp[0]['nome'];
                    
                  
                  //VERIFICAR SE EXISTE ATRASO NO PAGAMENTO DAS MATRICULAS
                     $query_3 = $pdo->query("SELECT * FROM pgto_matriculas where matricula = '$id_mat' ");
                    $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);
                   

                  for ($i2=0; $i2 < count($res_3); $i2++) { 
                  foreach ($res_3[$i2] as $key => $value) {
                  }

                  $data_venc = $res_3[$i2]['data_venc'];
                  $pago = $res_3[$i2]['pago'];

                  if($data_venc < date('Y-m-d') and $pago != 'Sim'){
                    $atrasado = 'Sim';
                    }

                   


              }
                
                ?>

              
                       <span><small>
                             <?php if($atrasado == 'Sim'){ ?>
                             <a class="text-danger" href="index.php?pag=<?php echo $pag ?>&funcao=pagamentos&id=<?php echo $id_mat ?>"><i><?php echo $nome_disc; 
                                 $atrasado = 'Não';
                              ?></i>
                             <?php }else{ ?>
                                 <a class="text-dark" href="index.php?pag=<?php echo $pag ?>&funcao=pagamentos&id=<?php echo $id_mat ?>"><i><?php echo $nome_disc ?></i>
                            <?php } ?>
                             - 
                            <?php echo $dia ?> 
                            <?php echo $horario ?> </a>
                            <br></small></span>
                            <hr style="margin:5px">
                       

                    <?php  } } ?>
               


        </div>

    </div>
</div>
</div>






<div class="modal" id="modal-pagamentos" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                 $id_m = $_GET['id'];
                     $query = $pdo->query("SELECT * FROM matriculas where id = '$id_m' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $id = $res[0]['aluno'];
                    $id_turma = $res[0]['turma'];

                     $query = $pdo->query("SELECT * FROM alunos where id = '$id' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $nome_aluno = $res[0]['nome'];

                      $query = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $disciplina = $res[0]['disciplina'];

                    $query = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $nome_disciplina = $res[0]['nome'];
                 ?>
                <h6 class="modal-title"><?php echo $nome_disciplina ?> - <?php echo $nome_aluno ?></h6>
                <a type="button" class="close" href="index.php?pag=<?php echo $pag ?>&funcao=turmas&id=<?php echo $id ?>" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </a>
                
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'pagamentos') {

                    $id2 = $_GET['id'];

                                     
                  
                  //VERIFICAR SE EXISTE ATRASO NO PAGAMENTO DAS MATRICULAS
                     $query_3 = $pdo->query("SELECT * FROM pgto_matriculas where matricula = '$id2' ");
                    $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);
                   

                  for ($i2=0; $i2 < count($res_3); $i2++) { 
                  foreach ($res_3[$i2] as $key => $value) {
                  }

                  $data_venc = $res_3[$i2]['data_venc'];
                  $pago = $res_3[$i2]['pago'];
                  $valor = $res_3[$i2]['valor'];
                  $id_pgto = $res_3[$i2]['id'];
                  $arquivo = $res_3[$i2]['arquivo'];

                  if($data_venc < date('Y-m-d') and $pago != 'Sim'){
                    $atrasado = 'Sim';
                    }

                  $valor = number_format($valor, 2, ',', '.');
                  $data_venc = implode('/', array_reverse(explode('-', $data_venc)));

                  
                  
             
                
                ?>

              
                       <span><small>
                             <?php if($atrasado == 'Sim'){ ?>
                             <span class="text-danger"><i><?php echo $data_venc; 
                                 $atrasado = 'Não';
                              ?></i></span>
                             <?php }else{ ?>
                                 <span class="text-dark"><i><?php echo $data_venc ?></i></span>
                            <?php } ?>
                             - 
                            R$ <?php echo $valor ?> 
                            Pago: <?php echo $pago ?>

                             <?php if($pago == 'Sim'){ ?>
                              <a href="index.php?pag=<?php echo $pag ?>&funcao=baixa&id=<?php echo $id_pgto ?>" class='text-success ml-2' title='Baixa no Pagamento'><i class='fas fa-check'></i></a>
                             <?php 
                             
                         }else{ 
                            ?>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=baixa&id=<?php echo $id_pgto ?>" class='text-danger ml-2' title='Baixa no Pagamento'><i class='fas fa-check'></i></a>
                            <?php } ?>



                             <?php if($pgto_boleto == 'Sim'){ ?>
                              <a href="index.php?pag=<?php echo $pag ?>&funcao=upload&id=<?php echo $id_pgto ?>&id_m=<?php echo $id2 ?>" class='text-primary ml-2' title='Carregar Boleto / Carnê'><i class='fas fa-paperclip'></i></a>

                              <?php if($arquivo != ''){ ?>
                                 <a href="../img/arquivos/<?php echo $arquivo ?>" class="text-dark ml-2" target="_blank" title="Abrir o Boleto / Carnê">Ver Arquivo</a>   
                             <?php } } ?>
                            

                            <br></small></span>
                       

                    <?php  } } ?>
               


        </div>

    </div>
</div>
</div>






<div class="modal" id="modal-upload" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Carregar Arquivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
            <div class="modal-body">

                 <div class="form-group">
                                <label >Arquivo</label>
                                <input type="file" class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
                            </div>

                            <div id="divImgConta">
                           
                                <img src="../img/arquivos/sem-foto.jpg" width="200" height="200" id="target">
                            
                            </div>

                              <small>
                <div id="mensagem-upload">

                </div>
            </small> 


            </div>


               <div class="modal-footer">

            <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
            <button type="button" id="btn-fechar-upload" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" name="btn-salvar-upload" id="btn-salvar-upload" class="btn btn-primary">Salvar</button>
        </div>
        </form>


        </div>

    </div>
</div>
</div>




<?php 


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "endereco") {
    echo "<script>$('#modal-endereco').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "turmas") {
    echo "<script>$('#modal-turmas').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "pagamentos") {
    echo "<script>$('#modal-pagamentos').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "baixa") {

    $id_pgto = $_GET['id'];

    require_once("baixar-mensalidade.php"); 

    echo "<script>window.location='index.php?pag=$pag&id=$id_mat&funcao=pagamentos';</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "upload") {
    echo "<script>$('#modal-upload').modal('show');</script>";
}

?>




<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function () {
        var pag = "<?=$pag?>";
        var id_mat = "<?=$_GET['id_m']?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/upload.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar-upload').click();
                    window.location = "index.php?pag="+pag+"&id="+id_mat+"&funcao=pagamentos";

                } else {

                    $('#mensagem-upload').addClass('text-danger')
                }

                $('#mensagem-upload').text(mensagem)

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
            $('#target').attr('src', "../img/arquivos/pdf.png");
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



