<?php
@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario'];
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'professor'){
	echo "<script language='javascript'> window.location='../index.php' </script>";
	exit();
}

require_once("../conexao.php"); 


//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";



$query = $pdo->query("SELECT * FROM professores where cpf = '$cpf_usuario' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_prof = $res[0]['id'];

$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalDisc = @count($res);

$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof' and data_final >= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalAndamento = @count($res);

$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof' and data_final < curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalConcluidas = @count($res);




$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof' and data_final >= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$totalAlunos = 0;
for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	
	$id_turma = $res[$i]['id'];

	$query2 = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$total_mat = @count($res2);
	$totalAlunos = $totalAlunos + $total_mat;
}


?>








<div class="row">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Disciplinas Ministradas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalDisc ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-info"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-secondary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total de Alunos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAlunos ?> </div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-secondary"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Turmas em Andamentos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAndamento ?> </div>
					</div>
					<div class="col-auto" align="center">
						<i class="fas fa-clipboard-list fa-2x text-danger"></i>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Turmas Concluídas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalConcluidas ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-success"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>




<div class="row">

	<?php 

	$query = $pdo->query("SELECT * FROM professores where cpf = '$cpf_usuario' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_prof = $res[0]['id'];



	$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof' order by data_final desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	for ($i=0; $i < count($res); $i++) { 
		foreach ($res[$i] as $key => $value) {
		}
		$disciplina = $res[$i]['disciplina'];
		$horario = $res[$i]['horario'];
		$dia = $res[$i]['dia'];
		$ano = $res[$i]['ano'];
		$data_final = $res[$i]['data_final'];
		$id_turma = $res[$i]['id'];

		$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

		$query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
		$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);

		$nome_disc = $res_resp[0]['nome'];


		if($data_final < date('Y-m-d')){
			$classe_card = 'text-success';
		}else{
			$classe_card = 'text-danger';
		}

		?>	

		<div class="col-xl-3 col-md-6 mb-4">
			<a class="text-dark" href="index.php?pag=turma&id=<?php echo $id_turma ?>" title="Informações da Turma">
				<div class="card <?php echo $classe_card ?> shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold  <?php echo $classe_card ?> text-uppercase"><?php echo $nome_disc ?></div>
								<div class="text-xs text-secondary"><?php echo $horario ?> <br> <?php echo $dia ?> </div>
							</div>
							<div class="col-auto" align="center">
								<i class="far fa-calendar-alt fa-2x  <?php echo $classe_card ?>"></i><br>
								<span class="text-xs"><?php echo $data_finalF ?></span>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>



	<?php } ?>

</div>