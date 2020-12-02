<?php 
$pag = "vencidas";
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
                        <th>Aluno</th>
                        <th>CPF</th>
                        <th>Disciplina</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM pgto_matriculas where data_venc < curDate() and pago != 'Sim' order by data_venc asc, id asc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $matricula = $res[$i]['matricula'];
                  $valor = $res[$i]['valor'];
                  $data_venc = $res[$i]['data_venc'];
                  $pago = $res[$i]['pago'];
                  $id = $res[$i]['id'];
                  
                  $query_r = $pdo->query("SELECT * FROM matriculas where id = '$matricula' ");
                  $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                  $id_turma =  $res_r[0]['turma'];
                  $id_aluno =  $res_r[0]['aluno'];

                   $query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
                    $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                    $disciplina = $res_2[0]['disciplina'];


                    $query_2 = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
                    $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                    $nome_disciplina = $res_2[0]['nome'];

                    $query_2 = $pdo->query("SELECT * FROM alunos where id = '$id_aluno' ");
                    $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                    $nome_aluno = $res_2[0]['nome'];
                    $cpf_aluno = $res_2[0]['cpf'];
                    
                    if($pago == 'Sim'){
                      $classe_square = 'text-success';
                    }else{
                      $classe_square = 'text-danger';
                    }

                     if($data_venc < date('Y-m-d')){
                      $classe_venc = 'text-danger';
                    }else{
                      $classe_venc = '';
                    }

                    $valor = number_format($valor, 2, ',', '.');
                    $data_venc = implode('/', array_reverse(explode('-', $data_venc)));

                  ?>


                  <tr>
                    <td>
                        <i class="fas fa-square <?php echo $classe_square ?> mr-1"></i>
                        <?php echo $nome_aluno ?></a>
                    </td>
                    <td><?php echo $cpf_aluno ?></td>
                    <td><?php echo $nome_disciplina ?></td>
                    <td>R$ <?php echo $valor ?></td>
                    <td><span class="<?php echo $classe_venc ?>"><?php echo $data_venc ?></span></td>


                    <td>
                        <?php if($pago != 'Sim'){ ?>
                        <a href="index.php?pag=<?php echo $pag ?>&funcao=baixar&id=<?php echo $id ?>" class='text-success mr-1' title='Baixar Pagamento'><i class='fas fa-check-square'></i></a>
                     <?php } ?>
                   </td>
               </tr>
           <?php } ?>





       </tbody>
   </table>
</div>
</div>
</div>




<div class="modal" id="modal-baixar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dar Baixa no Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Confirmar este Pagamento?</p>

                <div align="center" id="mensagem_excluir" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-primary">Baixar</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php 


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "baixar") {
    echo "<script>$('#modal-baixar').modal('show');</script>";
}

?>



<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function () {
        var pag = "<?=$pag?>";
        $('#btn-deletar').click(function (event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/baixar.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (mensagem) {

                    if (mensagem.trim() === 'Baixado com Sucesso!') {


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



