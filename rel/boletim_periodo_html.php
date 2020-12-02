<?php 
require_once("../conexao.php"); 


$id_turma = $_GET['id_turma'];
$id_periodo = $_GET['id_periodo'];
$id_aluno = $_GET['id_aluno'];

$query = $pdo->query("SELECT * FROM alunos where id = '$id_aluno'  order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_aluno = $res[0]['nome'];


$query = $pdo->query("SELECT * FROM periodos where id = '$id_periodo'  order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_periodo = $res[0]['nome'];
$minimo_media = $res[0]['minimo_media'];
$total_pontos = $res[0]['total_pontos'];

$query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$disciplina = $res_2[0]['disciplina'];
$horario = $res_2[0]['horario'];
$dia = $res_2[0]['dia'];
$ano = $res_2[0]['ano'];
$data_final = $res_2[0]['data_final'];
$data_inicio = $res_2[0]['data_inicio'];
$professor = $res_2[0]['professor'];

  

$query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_disc = $res_resp[0]['nome'];


$query_resp = $pdo->query("SELECT * FROM professores where id = '$professor' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_prof = $res_resp[0]['nome'];
$email_prof = $res_resp[0]['email'];
$imagem_prof = $res_resp[0]['foto'];


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))));



//TOTALIZAR NOTA DO PERIODO
$total_notas = 0;
$query = $pdo->query("SELECT * FROM notas where periodo = '$id_periodo' and aluno = '$id_aluno' order by id asc ");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);

			for ($i=0; $i < @count($res); $i++) { 
				foreach ($res[$i] as $key => $value) {
				}
				$descricao = $res[$i]['descricao'];
				$nota = $res[$i]['nota'];
				$nota_max = $res[$i]['nota_max'];
				
				
				$total_notas = $total_notas + $nota;

				if($total_notas < $minimo_media){
					$classe_nota = 'corvermelha';
				}else{
					$classe_nota = 'corazul';
				}
		
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Boletim por Período</title>
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

		hr{
			margin:8px;
			padding:1px;
		}

		.container{
			padding-left:50px;
			padding-right:50px;
		}

		.corazul{
			color:#4e81ed;
		}

		.corvermelha{
			color:#e3393e;
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
			<div class="col-sm-4 esquerda">	
				<big> Aluno <?php echo $nome_aluno ?>  </big>
			</div>
			<div class="col-sm-8 direita" align="right">	
				<big> <small><small> Data: <?php echo $data_hoje; ?></small></small> </big>
			</div>
		</div>


		<hr>


		<br><br>
		
		<p class="subtitulo" align="center"><b>BOLETIM <?php echo strtoupper($nome_disc) ?> - <?php echo strtoupper($nome_periodo) ?> -	<span class="<?php echo $classe_nota ?>"> <?php echo $total_notas ?> 
		PONTOS</b></p>
		</span>
		<br><br><br>


<table class='table' width='100%'  cellspacing='0' cellpadding='3'>
			<tr bgcolor='#f9f9f9' >
				<th><b>Descrição</b></th>
				<th><b>Nota Aluno</b></th>
				<th><b>Nota Possível</b></th>
				

			</tr>
			<?php 
			
			
			$query = $pdo->query("SELECT * FROM notas where periodo = '$id_periodo' and aluno = '$id_aluno' order by id asc ");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);

			for ($i=0; $i < @count($res); $i++) { 
				foreach ($res[$i] as $key => $value) {
				}
				$descricao = $res[$i]['descricao'];
				$nota = $res[$i]['nota'];
				$nota_max = $res[$i]['nota_max'];
				
								
				?>

				<tr>
					<td>
						<?php echo $descricao ?>
					</td>
					<td><span class="<?php echo $classe_nota ?>"><?php echo $nota ?></span> </td>
					
					<td><?php echo $nota_max ?> </td>


				</tr>
			<?php } ?>



		</table>

		<hr>

		<br><br>

		<?php if($total_notas < $minimo_media){ ?>
		<small><p align="center">Você obteve <span class="<?php echo $classe_nota ?>"><?php echo $total_notas ?> pontos</span> de <?php echo $total_pontos ?> pontos possíveis, você ficou abaixo da média neste <?php echo $nome_periodo ?></p></small>
		<?php }else{ ?>
		<small><p align="center">Você obteve<span class="<?php echo $classe_nota ?>"> <?php echo $total_notas ?>  pontos </span> de <?php echo $total_pontos ?> pontos possíveis, você ficou dentro da média neste <?php echo $nome_periodo ?></p></small>
		<?php } ?>

<br><br><br>
		
</div>
				<div class="footer">
		<p style="font-size:14px" align="center"><?php echo $rodape_relatorios ?></p> 
	</div>




				</body>
				</html>
