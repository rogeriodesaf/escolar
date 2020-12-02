<?php 
require_once("../../conexao.php"); 

@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario'];

$query = $pdo->query("SELECT * FROM alunos where cpf = '$cpf_usuario'  order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_aluno = $res[0]['id'];

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];

$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$nome = $res[$i]['nome'];
	$descricao = $res[$i]['descricao'];
	$arquivo = $res[$i]['arquivo'];
	$id_aula = $res[$i]['id'];

	echo 'Aula '. ($i+1) . ' - '. $nome;

	 $query2 = $pdo->query("SELECT * FROM chamadas where turma = '$turma' and aluno = '$id_aluno' and aula = '$id_aula' ");
                  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                  $presenca = @$res2[0]['presenca'];

                  if($presenca == 'P'){
                    $classe_chamada = 'text-success';
                  }else{
                    $classe_chamada = 'text-danger';
                  }

             if($presenca != ""){ ?>
                        - <span class="<?php echo @$classe_chamada ?>"><?php echo @$presenca ?></span><br>
                         <?php } else{
                         	echo ' - Próximas Aulas <br>';
                         }


}
	?>

