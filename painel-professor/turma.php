<?php 

@session_start();
$pag = "turma";

require_once("../conexao.php"); 

$id_turma = $_GET['id'];

$query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$disciplina = $res_2[0]['disciplina'];
$horario = $res_2[0]['horario'];
$dia = $res_2[0]['dia'];
$ano = $res_2[0]['ano'];
$data_final = $res_2[0]['data_final'];
$data_inicio = $res_2[0]['data_inicio'];
$professor = $res_2[0]['professor'];


                  	//RECUPERAR O TOTAL DE MESES ENTRE DATAS
$d1 = new DateTime($data_inicio);
$d2 = new DateTime($data_final);
$intervalo = $d1->diff( $d2 );
$anos = $intervalo->y;
$meses = $intervalo->m + ($anos * 12);

$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

$query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_disc = $res_resp[0]['nome'];


$query_resp = $pdo->query("SELECT * FROM professores where id = '$professor' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_prof = $res_resp[0]['nome'];
$email_prof = $res_resp[0]['email'];
$imagem_prof = $res_resp[0]['foto'];


$query_resp = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$total_alunos = @count($res_resp);

$id_get_periodo = @$_GET['id_periodo'];

$query_resp = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_get_periodo'");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                 
$total_aulas = @count($res_resp);



$query_resp = $pdo->query("SELECT * FROM periodos where id = '$id_get_periodo' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                 
$nome_periodo = $res_resp[0]['nome'];
$maximo_nota = $res_resp[0]['total_pontos'];


if($data_final < date('Y-m-d')){
 $concluido = 'Sim';
}else{
 $concluido = 'Não';
}

?>

<h6><?php echo strtoupper($nome_disc) ?></h6>
<hr>

<small>
  <div class="mb-3">
  
   <span class="mr-3"><i><b>Disciplina Concluída </b> <?php echo $concluido ?></i></span>
   <span class="mr-3"><i><b>Dias de Aula </b> <?php echo $dia ?></i></span>
   <span class="mr-3"><i><b>Horário Aula </b> <?php echo $horario ?></i></span>
   <span class="mr-3"><i><b>Ano Início </b> <?php echo $ano ?></i></span>
   <span class="mr-3"><i><b>Data da Conclusão </b> <?php echo $data_finalF ?></i></span>
 </div>
</small>

<hr>



<div class="row">

  <div class="col-xl-3 col-md-6 mb-4">
   <a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&chamada=sim" title="Fazer Chamada">
     <div class="card text-danger shadow h-100 py-2">
      <div class="card-body">
       <div class="row no-gutters align-items-center">
        <div class="col mr-2">
         <div class="text-xs font-weight-bold  text-danger text-uppercase">CHAMADA</div>
         <div class="text-xs text-secondary"> <?php echo $total_alunos ?> ALUNOS MATRICULADOS</div>
       </div>
       <div class="col-auto" align="center">
         <i class="far fa-calendar-alt fa-2x  text-danger"></i><br>
         <span class="text-xs"></span>
       </div>
     </div>
   </div>
 </div>
</a>
</div>




<div class="col-xl-3 col-md-6 mb-4">
	<a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&notas=sim" title="Informações da Turma">
   <div class="card text-primary shadow h-100 py-2">
    <div class="card-body">
     <div class="row no-gutters align-items-center">
      <div class="col mr-2">
       <div class="text-xs font-weight-bold  text-primary text-uppercase">BOLETIM</div>
       <div class="text-xs text-secondary"> LANÇAR NOTAS</div>
     </div>
     <div class="col-auto" align="center">
       <i class="fas fa-file-invoice fa-2x  text-primary"></i><br>
       <span class="text-xs"></span>
     </div>
   </div>
 </div>
</div>
</a>
</div>




<div class="col-xl-3 col-md-6 mb-4">
	<a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&aulas=sim" title="Lançar Aulas">
   <div class="card text-info shadow h-100 py-2">
    <div class="card-body">
     <div class="row no-gutters align-items-center">
      <div class="col mr-2">
       <div class="text-xs font-weight-bold  text-info text-uppercase">AULAS</div>
       <div class="text-xs text-secondary"> GRADE DO CURSO</div>
     </div>
     <div class="col-auto" align="center">
       <i class="fas fa-video fa-2x  text-info"></i><br>
       <span class="text-xs"></span>
     </div>
   </div>
 </div>
</div>
</a>
</div>





<div class="col-xl-3 col-md-6 mb-4">
  <a class="text-dark" href="index.php?pag=periodos&id=<?php echo $id_turma ?>" title="Cadastro de Períodos">
    <div class="card text-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold  text-dark text-uppercase">PERÍODOS</div>
            <div class="text-xs text-secondary"> PERÍODOS DO CURSO</div>
          </div>
          <div class="col-auto" align="center">
            <i class="fas fa-calendar-day fa-2x  text-dark"></i><br>
            <span class="text-xs"></span>
          </div>
        </div>
      </div>
    </div>
  </a>
</div>




</div>










<div class="modal" id="modal-aulas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_periodo ?> - <?php echo $total_aulas ?> Aulas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-7">

            <span class=""><b>Aulas do Curso</b></span>
            <small><div id="listar-aulas" class="mt-2">

            </div></small>

          </div>
          <div class="col-md-5">

            <span class="mb-2"><b>Inserir nova Aula</b></span>


            <form id="form" method="POST" class="mt-2">

              <div class="form-group">
               <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da Aula">
             </div>

             <div class="form-group">
               <textarea placeholder="Descrição do conteúdo da aula caso tenha" class="form-control" id="descricao" name="descricao"></textarea>  
             </div>

             <div align="right">
              <button type="submit" name="btn-salvar-aula" id="btn-salvar-aula" class="btn btn-primary">Salvar</button>
            </div>

            <input type="hidden" name="turma" value="<?php echo $_GET['id'] ?>">
            <input type="hidden" name="periodo" value="<?php echo $_GET['id_periodo'] ?>">

            <?php $id_per = @$_GET['id_periodo']; ?>

          </form>
        </div>
      </div>

      <div align="center" id="mensagem_aulas" class="">

      </div>

    </div>

  </div>
</div>
</div>





<div class="modal" id="modal-periodos" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php 
        $query = $pdo->query("SELECT * FROM periodos where turma = '$id_turma' order by id asc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $nome = $res[$i]['nome'];
          $id_periodo = $res[$i]['id'];
          ?>

         <?php if(@$_GET['aulas'] != ""){ ?>
          <a href="index.php?pag=turma&funcao=aulas&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>" name="btn-salvar-aula" class="btn btn-secondary text-light"><?php echo $nome ?></a>
        <?php } ?>

         <?php if(@$_GET['notas'] != ""){ ?>
          <a href="index.php?pag=turma&funcao=notas&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>" name="btn-salvar-aula" class="btn btn-secondary text-light"><?php echo $nome ?></a>
        <?php } ?>


          <?php if(@$_GET['chamada'] != ""){ ?>
          <a href="index.php?pag=turma&funcao=chamada&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>" name="btn-salvar-aula" class="btn btn-secondary text-light"><?php echo $nome ?></a>
        <?php } ?>


        <?php } ?>

      </div>

    </div>
  </div>
</div>





<div class="modal" id="modal-upload" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Carregar Arquivo </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form id="form2" method="POST">
      <div class="modal-body">

         <div class="form-group">
                                <label >Imagem</label>
                                <input type="file" value="<?php echo @$foto2 ?>"  class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
                            </div>

                            <div id="divImgConta">
                            <?php if(@$foto2 != ""){ ?>
                                <img src="../img/arquivos-aula/<?php echo $foto2 ?>" width="200" height="200" id="target">
                            <?php  }else{ ?>
                                <img src="../img/arquivos-aula/sem-foto.jpg" width="200" height="200" id="target">
                            <?php } ?>
                            </div>

                             <small>
                <div id="mensagem-upload">

                </div>
            </small> 
       

      </div>

        <div class="modal-footer">



            <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtidaula" id="txtidaula">
          

            <button type="button" id="btn-cancelar-upload" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" name="btn-salvar-upload" id="btn-salvar-upload" class="btn btn-primary">Salvar</button>
        </div>
    </form>

    </div>
  </div>
</div>







<div class="modal" id="modal-notas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lançar Notas </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form id="form2" method="POST">
      <div class="modal-body">

       <!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                       
                        <th>Email</th>
                       
                        <th>Foto</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma' order by id desc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $aluno = $res[$i]['aluno'];

                   $query_r = $pdo->query("SELECT * FROM alunos where id = '$aluno' ");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                  $nome = $res_r[0]['nome'];
                  $telefone = $res_r[0]['telefone'];
                  $email = $res_r[0]['email'];
                  $endereco = $res_r[0]['endereco'];
                  $cpf = $res_r[0]['cpf'];
                  $foto = $res_r[0]['foto'];
                  $id_aluno = $res_r[0]['id'];


                  ?>


                  <tr>
                    <td>
                        <?php echo $nome ?>
                      </td>
                   
                    <td><?php echo $email ?></td>
                  
                    <td><img src="../img/alunos/<?php echo $foto ?>" width="50"></td>


                    <td>
                        <a onclick="lancarNotas(<?php echo $id_aluno ?>, '<?php echo $nome ?>', <?php echo $maximo_nota ?>)" href="" class='text-info mr-1' title='Lançar Notas'><i class='fas fa-sticky-note fa-1x'></i></a>
                   </td>
               </tr>
           <?php } ?>





       </tbody>
   </table>
</div>
</div>
</div>

       

      </div>

       
    </form>

    </div>
  </div>
</div>






<div class="modal" id="modal-lancar-notas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_periodo ?> - <span id="txtnomealuno"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-7">

            <span class=""><b>Notas do Aluno </b></span>
            - <span id="total_notas">  </span> de <span id="maximonota"> <?php echo $maximo_nota ?></span> Pontos
            <small><div id="listar-notas" class="mt-2">

            </div></small>

          </div>
          <div class="col-md-5">

            <span class="mb-2"><b>Inserir nova Nota</b></span>


            <form id="form-notas" method="POST" class="mt-2">

              <div class="form-group">
               <input type="text" class="form-control" id="descricao-nota" name="descricao" placeholder="Trabalho, Prova, Participação, etc">
             </div>

             
                 <div class="form-group">
               <input type="text" class="form-control" id="nota" name="nota" placeholder="Valor da Nota do Aluno">
             </div>
            
                 <div class="form-group">
               <input type="text" class="form-control" id="nota-max" name="nota-max" placeholder="Nota Máxima Possível">
             </div>
            
             

             <div align="right">
              <button type="submit" name="btn-salvar-nota" id="btn-salvar-nota" class="btn btn-primary mb-4">Salvar</button>
            </div>

            <input type="hidden" name="turma" value="<?php echo $_GET['id'] ?>">
            <input type="hidden" name="periodo" value="<?php echo $_GET['id_periodo'] ?>">
            <input type="hidden" id="txtidaluno" name="aluno">

           

          </form>
        </div>
      </div>

      <small> <div align="center" id="mensagem-notas" class=""></div></small>

    </div>

  </div>
</div>
</div>








<div class="modal" id="modal-chamada-aulas" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_periodo ?> - <?php echo $total_aulas ?> Aulas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      

            <span class=""><b>Aulas do Curso</b></span>
            <small><div id="listar-aulas-chamada" class="mt-2">

            </div></small>


      <div align="center" id="mensagem_chamada" class="">

      </div>

    </div>

  </div>
</div>
</div>








<div class="modal" id="modal-chamada" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Fazer Chamada </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form id="form3" method="POST">
      <div class="modal-body">

       <!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                       
                        <th>Email</th>
                       
                        <th>Foto</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma' order by id asc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $aluno = $res[$i]['aluno'];

                   $query_r = $pdo->query("SELECT * FROM alunos where id = '$aluno' order by nome asc");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                  $nome = $res_r[0]['nome'];
                  $telefone = $res_r[0]['telefone'];
                  $email = $res_r[0]['email'];
                  $endereco = $res_r[0]['endereco'];
                  $cpf = $res_r[0]['cpf'];
                  $foto = $res_r[0]['foto'];
                  $id_aluno = $res_r[0]['id'];


                   $query2 = $pdo->query("SELECT * FROM chamadas where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                  $presenca = $res2[0]['presenca'];

                  if($presenca == 'P'){
                    $classe_chamada = 'text-success';
                  }else{
                    $classe_chamada = 'text-danger';
                  }

                  ?>


                  <tr>
                    <td>
                        <?php echo $nome ?>
                      </td>
                   
                    <td><?php echo $email ?></td>
                  
                    <td><img src="../img/alunos/<?php echo $foto ?>" width="50"></td>


                    <td>
                       <a href="index.php?pag=<?php echo $pag ?>&funcao=presenca&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>" class='text-success mr-1' title='Presente'><i class='far fa-check-circle'></i></a>

                        <a href="index.php?pag=<?php echo $pag ?>&funcao=falta&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>" class='text-danger mr-1' title='Falta'><i class='far fa-circle'></i></a>


                        <a href="index.php?pag=<?php echo $pag ?>&funcao=justificado&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>" class='text-info mr-1' title='Justificar Falta'><i class='fas fa-question-circle fa-1x'></i></a>

                        <?php if($presenca != ""){ ?>
                        - <span class="<?php echo $classe_chamada ?>"><?php echo $presenca ?></span>
                         <?php } ?>

                        

                   </td>
               </tr>
           <?php } ?>





       </tbody>
   </table>
</div>
</div>
</div>

       

      </div>

       
    </form>

    </div>
  </div>
</div>





<?php 

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "aulas") {
  echo "<script>$('#modal-aulas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "periodos") {
  echo "<script>$('#modal-periodos').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "notas") {
  echo "<script>$('#modal-notas').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "chamada") {
  echo "<script>$('#modal-chamada-aulas').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "fazerchamada") {
  echo "<script>$('#modal-chamada').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "presenca") {
  
  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];
  $id_periodo_chamada = $_GET['id_periodo'];

  $query = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(@count($res) > 0){
    $id_chamada = $res[0]['id'];
    $pdo->query("UPDATE chamadas SET presenca = 'P' where id = '$id_chamada'");
  }else{
      $pdo->query("INSERT INTO chamadas SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), periodo = '$id_periodo_chamada'");
  }

   echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_periodo=$id_periodo_chamada&id_aula=$id_aula_chamada';</script>";


}



if (@$_GET["funcao"] != null && @$_GET["funcao"] == "falta") {
  
  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];
  $id_periodo_chamada = $_GET['id_periodo'];

  $query = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(@count($res) > 0){
    $id_chamada = $res[0]['id'];
    $pdo->query("UPDATE chamadas SET presenca = 'F' where id = '$id_chamada'");
  }else{
      $pdo->query("INSERT INTO chamadas SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), periodo = '$id_periodo_chamada'");
  }

   echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_periodo=$id_periodo_chamada&id_aula=$id_aula_chamada';</script>";


}



if (@$_GET["funcao"] != null && @$_GET["funcao"] == "justificado") {
  
  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];
  $id_periodo_chamada = $_GET['id_periodo'];

  $query = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(@count($res) > 0){
    $id_chamada = $res[0]['id'];
    $pdo->query("UPDATE chamadas SET presenca = 'J' where id = '$id_chamada'");
  }else{
      $pdo->query("INSERT INTO chamadas SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), periodo = '$id_periodo_chamada'");
  }

   echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_periodo=$id_periodo_chamada&id_aula=$id_aula_chamada';</script>";


}

?>




<!--AJAX PARA LISTAR OS DADOS -->
<script type="text/javascript">
  $(document).ready(function(){
   listarDados();
   listarAulasChamada();

 })
</script>


<script type="text/javascript">
  function listarDados(){
    var pag = "<?=$pag?>";
    var turma = "<?=$id_turma?>";
    var periodo = "<?=$id_per?>";
    console.log(periodo)
    $.ajax({
     url: pag + "/listar-aulas.php",
     method: "post",
     data: {turma, periodo},
     dataType: "html",
     success: function(result){
      $('#listar-aulas').html(result)

    },


  })
  }
</script>




<script type="text/javascript">
  function listarAulasChamada(){
    var pag = "<?=$pag?>";
    var turma = "<?=$id_turma?>";
    var periodo = "<?=$id_per?>";
    console.log(periodo)
    $.ajax({
     url: pag + "/listar-aulas-chamada.php",
     method: "post",
     data: {turma, periodo},
     dataType: "html",
     success: function(result){
      $('#listar-aulas-chamada').html(result)

    },


  })
  }
</script>


<script type="text/javascript">
  function listarDadosNotas(aluno){
    var pag = "<?=$pag?>";
    var turma = "<?=$id_turma?>";
    var periodo = "<?=$id_per?>";
    
    $.ajax({
     url: pag + "/listar-notas.php",
     method: "post",
     data: {turma, periodo, aluno},
     dataType: "html",
     success: function(result){
      $('#listar-notas').html(result)

    },


  })
  }
</script>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form").submit(function () {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir-aula.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        $('#mensagem').removeClass()

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#nome').val('');
          $('#descricao').val('');
          listarDados();

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







<script type="text/javascript">
  function deletarAula(idaula) {
    event.preventDefault();
    var pag = "<?=$pag?>";
    
      $.ajax({
        url: pag + "/excluir-aula.php",
        method: "post",
        data: {idaula},
        dataType: "text",
        success: function (mensagem) {

          if (mensagem.trim() === 'Excluído com Sucesso!') {


            listarDados();
          }

         

        },

      })
    }
  
</script>





<script type="text/javascript">
  function upload(idaula) {
    event.preventDefault();
    var pag = "<?=$pag?>";
       document.getElementById('txtidaula').value = idaula;
      $('#modal-upload').modal('show');
    }
  
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
            $('#target').attr('src', "../img/arquivos-aula/pdf.png");
            return;
        }

         if(resultado[1] === 'rar'){
            $('#target').attr('src', "../img/arquivos-aula/zip.png");
            return;
        }


         if(resultado[1] === 'zip'){
            $('#target').attr('src', "../img/arquivos-aula/zip.png");
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







<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form2").submit(function () {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/upload.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        $('#mensagem').removeClass()

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#nome').val('');
          $('#descricao').val('');
          listarDados();
          $('#btn-cancelar-upload').click();

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




<script type="text/javascript">
  function lancarNotas(idaluno, nomealuno, maximonota) {
    event.preventDefault();
    
    var pag = "<?=$pag?>";
       document.getElementById('txtidaluno').value = idaluno;
       
       $("#txtnomealuno").text(nomealuno);
       $("#maximonota").text(maximonota);

       listarDadosNotas(idaluno);

       $('#modal-lancar-notas').modal('show');
    }
  
</script>






<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-notas").submit(function () {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir-nota.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        $('#mensagem-notas').removeClass()

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#descricao-nota').val('');
          $('#nota').val('');
          $('#nota-max').val('');
          listarDadosNotas(document.getElementById('txtidaluno').value);

        } else {

          $('#mensagem-notas').addClass('text-danger')
        }

        $('#mensagem-notas').text(mensagem)

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






<script type="text/javascript">
  function deletarNota(idnota) {
    event.preventDefault();
    var pag = "<?=$pag?>";
    
      $.ajax({
        url: pag + "/excluir-nota.php",
        method: "post",
        data: {idnota},
        dataType: "text",
        success: function (mensagem) {

          if (mensagem.trim() === 'Excluído com Sucesso!') {


            listarDadosNotas(document.getElementById('txtidaluno').value);
          }

         

        },

      })
    }
  
</script>


