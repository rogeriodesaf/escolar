<?php
@session_start();
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
	echo "<script language='javascript'> window.location='../index.php' </script>";
}

require_once("../conexao.php"); 


//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";





$saldo = 0;
$entradas = 0;
$saidas = 0;
$query = $pdo->query("SELECT * FROM movimentacoes where data = curDate() ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < @count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	
	$tipo = $res[$i]['tipo'];
	
	$valor = $res[$i]['valor'];

	if($tipo == 'Entrada'){
		$entradas = $entradas + $valor;
	}else{
		$saidas = $saidas + $valor;
	}
	$saldo = $entradas - $saidas;

	$saldoDia = number_format($saldo, 2, ',', '.');
	$entradas = number_format($entradas, 2, ',', '.');
	$saidas = number_format($saidas, 2, ',', '.');

}




$saldoMes = 0;
$entradasMes = 0;
$saidasMes = 0;
$query = $pdo->query("SELECT * FROM movimentacoes where data >= '$dataInicioMes' and data <= curDate() ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < @count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	
	$tipo = $res[$i]['tipo'];
	
	$valor = $res[$i]['valor'];

	if($tipo == 'Entrada'){
		$entradasMes = $entradasMes + $valor;
	}else{
		$saidasMes = $saidasMes + $valor;
	}
	$saldoMes = $entradasMes - $saidasMes;

	$saldoMes = number_format($saldoMes, 2, ',', '.');
	

}



$query = $pdo->query("SELECT * FROM contas_pagar where data_venc = curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$vencimentosDia = @count($res);
$total_vencimento_dia = 0;
for ($i=0; $i < @count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	$total_vencimento_dia = $total_vencimento_dia + $res[$i]['valor'];
}
$total_vencimento_dia = number_format($total_vencimento_dia, 2, ',', '.');





$query = $pdo->query("SELECT * FROM alunos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$alunosCadastrados = @count($res);

$query = $pdo->query("SELECT * FROM professores");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalProf = @count($res);

$query = $pdo->query("SELECT * FROM turmas");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalTurmas = @count($res);

$query = $pdo->query("SELECT * FROM disciplinas");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalDisc = @count($res);




//CAPTURAR % DE INADIMPLENCIA
$query = $pdo->query("SELECT * FROM pgto_matriculas where data_venc < curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalMatriculas = @count($res);

$query = $pdo->query("SELECT * FROM pgto_matriculas where data_venc < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalMatriculasPendentes = @count($res);

$porcentagemInad = ($totalMatriculasPendentes * 100) / $totalMatriculas;
$porcentagemInad = number_format($porcentagemInad, 2, ',', '.');



//QUANTIDADE DE ALUNOS INADIMPLENTES
$total_alunos_debito = 0;

$query = $pdo->query("SELECT * FROM alunos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for ($i=0; $i < @count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	$id_aluno = $res[$i]['id'];
	$id_aluno_novo = 0;

	$query2 = $pdo->query("SELECT * FROM matriculas where aluno = '$id_aluno'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		for ($i2=0; $i2 < @count($res2); $i2++) { 
		foreach ($res2[$i2] as $key => $value) {
		}
		$id_mat = $res2[$i2]['id'];
		

		$query3 = $pdo->query("SELECT * FROM pgto_matriculas where matricula = '$id_mat' and data_venc < curDate() and pago != 'Sim' ");
			$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
			if(@count($res3)>0 and $id_aluno_novo != $id_aluno){
				$total_alunos_debito += 1;
			}

		$id_aluno_novo = $res2[$i2]['aluno'];
			
			

	}
}



?>

<div class="row">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entradas do Dia</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$entradas ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x text-success"></i>
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
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Saídas do Dia</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saidas ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x text-danger"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card <?php echo $corTotal2 ?> shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold <?php echo $corTotal ?> text-uppercase mb-1">Saldo do Dia</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ R$ <?php echo @$saldo ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x <?php echo $corTotal ?>"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card <?php echo $corTotal2Mes ?> shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold <?php echo $corTotalMes ?> text-uppercase mb-1">Saldo do Mês</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saldoMes ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x <?php echo $corTotalMes ?>"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>








<div class="row">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">% Inadimplência</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$porcentagemInad ?> %</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-danger"></i>
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
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Alunos Inadimplêntes</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$total_alunos_debito; ?> </div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-danger"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vencimentos Dia</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$vencimentosDia ?> </div>
					</div>
					<div class="col-auto" align="center">
						<i class="fas fa-clipboard-list fa-2x text-primary"></i>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Vencimento R$</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$total_vencimento_dia ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-danger"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>







<div class="row">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Alunos Cadastrados</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$alunosCadastrados ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-info"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Professores</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalProf ?> </div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-success"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Disciplinas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalDisc ?> </div>
					</div>
					<div class="col-auto" align="center">
						<i class="fas fa-clipboard-list fa-2x text-primary"></i>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-secondary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total Turmas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalTurmas ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-secondary"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>