<?php
@session_start();
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'tesoureiro'){
	echo "<script language='javascript'> window.location='../index.php' </script>";
}

require_once("../conexao.php"); 


//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";



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



$query = $pdo->query("SELECT * FROM pgto_matriculas where data_venc > curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$mensalidadesVenc = @count($res);


$query = $pdo->query("SELECT * FROM pgto_matriculas where data_venc = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$mensalidadesVencHoje = @count($res);



$query = $pdo->query("SELECT * FROM pgto_matriculas where data_venc > curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_vencimento_mat = 0;
for ($i=0; $i < @count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	$total_vencimento_mat = $total_vencimento_mat + $res[$i]['valor'];
}
$total_vencimento_mat = number_format($total_vencimento_mat, 2, ',', '.');





$query = $pdo->query("SELECT * FROM movimentacoes where descricao = 'Pagamento Mensalidade' and data = curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalPagoHoje = @count($res );
$totalPagoHojeR = 0;
for ($i=0; $i < @count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	$totalPagoHojeR = $totalPagoHojeR + $res[$i]['valor'];
}
$totalPagoHojeR = number_format($totalPagoHojeR, 2, ',', '.');



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

}

?>





<div class="row">
	

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vencimentos Dia</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$vencimentosDia ?> </div>
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
						<i class="fas fa-dollar-sign fa-2x text-danger"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Mensalidades Vencidas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$mensalidadesVenc ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-danger"></i>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mensalid Vencendo Hoje</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$mensalidadesVencHoje ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-primary"></i>
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
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mensalidades Venc R$</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$total_vencimento_mat ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x text-info"></i>
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
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mensalid Pagas Hoje</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalPagoHoje ?> </div>
					</div>
					<div class="col-auto" align="center">
						<i class="fas fa-clipboard-list fa-2x text-primary"></i>

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
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mensalid Pagas Hoje R$</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$totalPagoHojeR ?> </div>
					</div>
					<div class="col-auto" align="center">
						<i class="fas fa-dollar-sign fa-2x text-success"></i>

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
						<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Saldo Dia</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saldoDia ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x text-secondary"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>