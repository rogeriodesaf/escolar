<?php 
require_once("../conexao.php"); 


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))));

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$status = $_GET['status'];

$status_like = '%'.$status.'%';

$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));

if($status == 'Entrada'){
	$status_serv = 'de Entradas ';
}else if($status == 'Saída'){
	$status_serv = 'de Saídas';

}else{
	$status_serv = '';
}


if($dataInicial != $dataFinal){
	$apuracao = $dataInicialF. ' até '. $dataFinalF;
}else{
	$apuracao = $dataInicialF;
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Movimentações</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>

		@page {
			margin: 0px;

		}

		.footer {
			margin-top:20px;
			width:100%;
			background-color: #ebebeb;
			padding:10px;
			position:relative;
			bottom:0;
		}

		.cabecalho {    
			background-color: #ebebeb;
			padding:10px;
			margin-bottom:30px;
			width:100%;
			height:100px;
		}

		.titulo{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.subtitulo{
			margin:0;
			font-size:17px;
			font-family:Arial, Helvetica, sans-serif;
		}

		.areaTotais{
			border : 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right:25px;
			margin-left:25px;
			position:absolute;
			right:20;
		}

		.areaTotal{
			border : 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right:25px;
			margin-left:25px;
			background-color: #f9f9f9;
			margin-top:2px;
		}

		.pgto{
			margin:1px;
		}

		.fonte13{
			font-size:13px;
		}

		.esquerda{
			display:inline;
			width:50%;
			float:left;
		}

		.direita{
			display:inline;
			width:50%;
			float:right;
		}

		.table{
			padding:15px;
			font-family:Verdana, sans-serif;
			margin-top:20px;
		}

		.texto-tabela{
			font-size:12px;
		}


		.esquerda_float{

			margin-bottom:10px;
			float:left;
			display:inline;
		}


		.titulos{
			margin-top:10px;
		}

		.image{
			margin-top:-10px;
		}

		.margem-direita{
			margin-right: 80px;
		}

		.margem-direita50{
			margin-right: 50px;
		}

		hr{
			margin:8px;
			padding:1px;
		}


		.titulorel{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.margem-superior{
			margin-top:30px;
		}


	</style>


</head>
<body>


	<div class="cabecalho">
		
			<div class="row titulos">
				<div class="col-sm-2 esquerda_float image">	
					<img src="../img/logo.png" width="170px">
				</div>
				<div class="col-sm-10 esquerda_float">	
					<h2 class="titulo"><b><?php echo strtoupper($nome_escola) ?></b></h2>
					<h6 class="subtitulo"><?php echo $endereco_escola . ' Tel: '.$telefone_escola  ?></h6>

				</div>
			</div>
		

	</div>

	<div class="container">

		<div class="row">
			<div class="col-sm-8 esquerda">	
				<span class="titulorel"> Relatório de Movimentações <?php echo $status_serv ?> </span>
			</div>
			<div class="col-sm-4 direita" align="right">	
				<big> <small> Data: <?php echo $data_hoje; ?></small> </big>
			</div>
		</div>


		<hr>


		<div class="row margem-superior">
			<div class="col-md-12">
				<div class="esquerda_float margem-direita50">	
					<span class=""> <b> Período da Apuração </b> </span>
				</div>
				<div class="esquerda_float margem-direita50">	
					<span class=""> <?php echo $apuracao ?> </span>
				</div>
				
			</div>
		</div>

		<hr>

<table class='table' width='100%'  cellspacing='0' cellpadding='3'>
			<tr bgcolor='#f9f9f9' >
				<th><b>Tipo</b></th>
				<th><b>Descrição</b></th>
				<th><b>Valor</b></th>
				<th><b>Funcionário</b></th>
				<th><b>Data</b></th>

			</tr>
			<?php 
			$saldo = 0;
			$entradas = 0;
			$saidas = 0;
			$query = $pdo->query("SELECT * FROM movimentacoes where data >= '$dataInicial' and data <= '$dataFinal' and tipo LIKE '$status_like' order by data asc, id asc ");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);

			for ($i=0; $i < @count($res); $i++) { 
				foreach ($res[$i] as $key => $value) {
				}
				$descricao = $res[$i]['descricao'];
				$tipo = $res[$i]['tipo'];
				$funcionario = $res[$i]['funcionario'];
				$data = $res[$i]['data'];
				$valor = $res[$i]['valor'];

				if($tipo == 'Entrada'){
					$entradas = $entradas + $valor;
				}else{
					$saidas = $saidas + $valor;
				}
				$saldo = $entradas - $saidas;

				$entradasF = number_format($entradas, 2, ',', '.');
				$saidasF = number_format($saidas, 2, ',', '.');
				$saldoF = number_format($saldo, 2, ',', '.');


				$id = $res[$i]['id'];

				$query_usu = $pdo->query("SELECT * FROM usuarios where cpf = '$funcionario'");
				$res_usu = $query_usu->fetchAll(PDO::FETCH_ASSOC);
				$nome_func = $res_usu[0]['nome'];

				$valor = number_format($valor, 2, ',', '.');
				$data = implode('/', array_reverse(explode('-', $data)));

				if($tipo == 'Entrada'){
					$cor_pago = 'text-success';
				}else{
					$cor_pago = 'text-danger';
				}

				?>

				<tr>
					<td>
						<?php echo $tipo ?>
					</td>
					<td><?php echo $descricao ?> </td>
					<td>R$ <?php echo $valor ?> </td>
					<td><?php echo $nome_func ?> </td>
					<td><?php echo $data ?> </td>


				</tr>
			<?php } ?>



		</table>


		<hr>


		<div class="row margem-superior">
			<div class="col-md-12">
				<div class="" align="right">
				<span class="areaTotal">
				<span class="margem-direita50 text-success">
				 <b> Entradas : R$ <?php echo $entradasF ?> </b>  
				</span>
				<span class="text-danger">
				 <b> Saídas : R$ <?php echo $saidasF ?> </b>  
				</span>
				</span>
				
					<span class="areaTotal"> <b> Saldo : R$ <?php echo $saldoF ?> </b> </span>
				</div>

			</div>
		</div>

		

<br><br><br>
		
</div>
				<div class="footer">
		<p style="font-size:14px" align="center"><?php echo $rodape_relatorios ?></p> 
	</div>




				</body>
				</html>
