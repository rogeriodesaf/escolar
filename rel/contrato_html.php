<?php 
require_once("../conexao.php"); 
@session_start();

$id = $_GET['id'];

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))));


//DADOS DA MATRÍCULA
$query_orc = $pdo->query("SELECT * FROM matriculas where id = '$id' ");
$res_orc = $query_orc->fetchAll(PDO::FETCH_ASSOC);
$turma = $res_orc[0]['turma'];
$aluno = $res_orc[0]['aluno'];
$data = $res_orc[0]['data'];


$query_r = $pdo->query("SELECT * FROM alunos where id = '$aluno' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$nome_aluno = $res_r[0]['nome'];
$cpf_aluno = $res_r[0]['cpf'];
$responsavel = $res_r[0]['responsavel'];
$endereco_aluno = $res_r[0]['endereco'];
$telefone_aluno = $res_r[0]['telefone'];

if($responsavel != ""){
	$query_r = $pdo->query("SELECT * FROM responsaveis where cpf = '$responsavel' ");
	$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
	$nome_aluno = $res_r[0]['nome'];
	$cpf_aluno = $res_r[0]['cpf'];
	$endereco_aluno = $res_r[0]['endereco'];
	$telefone_aluno = $res_r[0]['telefone'];
}


$query_r = $pdo->query("SELECT * FROM turmas where id = '$turma' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$disciplina = $res_r[0]['disciplina'];
$data_inicio = $res_r[0]['data_inicio'];
$data_final = $res_r[0]['data_final'];
$valor = $res_r[0]['valor_mensalidade'];



//RECUPERAR O TOTAL DE MESES ENTRE DATAS
$d1 = new DateTime($data_inicio);
$d2 = new DateTime($data_final);
$intervalo = $d1->diff( $d2 );
$anos = $intervalo->y;
$meses = $intervalo->m + ($anos * 12);



$data_inicioF = implode('/', array_reverse(explode('-', $data_inicio)));
$data_finalF = implode('/', array_reverse(explode('-', $data_final)));
$valor_total = $valor * $meses;
$valor_mensalidadeF = number_format($valor, 2, ',', '.');
$valor_totalF = number_format($valor_total, 2, ',', '.');

$query_r = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$nome_disciplina = $res_r[0]['nome'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Contrato de Matrícula</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>

		@page {
			margin: 0px;
			margin-bottom:30px;
			
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
			padding-bottom:50px;
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
			<div class="col-sm-7 esquerda">	
				<big> Matrícula Nº <?php echo $id ?>  </big>
			</div>
			<div class="col-sm-5 direita" align="right">	
				<big> <small> Data: <?php echo $data_hoje; ?></small> </big>
			</div>
		</div>


		<hr>



		<p align="center"><b>CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS</b></p>
		<br><br>


<p><b>CONTRATANTE:</b> <?php echo $nome_aluno ?>, Brasileiro(a), CPF nº <?php echo $cpf_aluno ?>, telefone <?php echo $telefone_aluno ?> residente e domiciliado na <?php echo $endereco_aluno ?>.</p>

<p>
<b>CONTRATADA:</b> <?php echo $nome_escola ?>, com sede na <?php echo $endereco_escola ?>, inscrita no CNPJ sob o nº xxxxx, e no Cadastro Estadual sob o nº <?php echo $cnpj_escola ?>, neste ato representada pelo senhor (Nome), (nacionalidade), (estado civil), (profissão), portador da cédula de identidade R.G. nº xxxxx e CPF/MF nº xxxxxx, residente e domiciliado na (Rua), (número), (bairro), (CEP), (Cidade), (Estado).</p>

<p>
As partes acima acordam com o presente Contrato de Prestação de Serviços Educacionais, que se regerá pelas cláusulas seguintes:
</p>

<p><b>
DO OBJETO DO CONTRATO
</b></p>

<p>
Contrato por matrícula no curso  <?php echo $nome_disciplina ?>, por <?php echo $meses ?> Meses, com mensalidades no valor de R$ <?php echo $valor_mensalidadeF ?>, com data inicial prevista para <?php echo $data_inicioF ?> e data Final <?php echo $data_finalF ?>, num valor total de R$ <?php echo $valor_totalF ?>.
</p>	

<p>
Cláusula 1ª. O OBJETO do presente instrumento é a prestação de serviços educacionais, pela CONTRATADA, sendo os mesmos prestados na Escola (Nome), localizada na (Rua), (número), (bairro), (CEP), (Cidade), (Estado), para o ano letivo de (ano), em favor de (Nome), representado neste instrumento pelo CONTRATANTE.</p>

<p><b>
DA OBRIGAÇÂO DA CONTRATADA
</b></p>

<p>
Cláusula 2ª. Está obrigada a CONTRATADA em fornecer gratuitamente ao aluno, quaisquer certificados, em especial o de freqüência escolar bem como o de conclusão e os materiais pertinentes a realização das provas.
</p>

<p><b>
DOS DESCONTOS
</b></p>

<p>
Cláusula 3ª. Poderá a CONTRATADA, por sua iniciativa, oferecer ao aluno, neste instrumento representado pelo CONTRATANTE, abatimentos nas mensalidades, descriminados no boleto bancário mensal.
</p>

<p><b>
DO PAGAMENTO
</b></p>

<p>
Cláusula 4ª. É obrigação do CONTRATANTE, efetuar os pagamentos mensais para a CONTRATADA, da quantia mensal de R$ xxxx (Valor), referente aos serviços educacionais.
</p>

<p>
Cláusula 5ª. As mensalidades deverão ser pagas em qualquer banco até o vencimento ou após este, seguindo as intrusões no próprio boleto, podendo ainda ser realizada na sede da escola, localizada na (Rua), (número), (bairro), (CEP), (Cidade), (Estado), até o dia xx de cada mês.
</p>

<p><b>
DO INADIMPLEMENTO
</b></p>

<p>
Cláusula 6ª. Deixando o CONTRATANTE de efetuar o pagamento da mensalidade dentro do prazo estipulado, a este será imposta multa de xx% do valor da parcela, mais juros de x% ao mês.
</p>

<p><b>
DA RESCISÃO
</b></p>

<p>
Cláusula 7ª. Este CONTRATO pode ser rescindido por qualquer das partes, não havendo necessidade de aviso a parte contraria, porem todas as parcelas devem estar pagas na ocasião.
</p>

<p>
Cláusula 8ª. Pode a CONTRATADA rescindir o presente contrato, após reunião interna do conselho de professores, por indisciplina do aluno representado neste instrumento, ou por inadimplência do CONTRATANTE, por mais de xx meses consecutivos, sendo o mesmo avisado antecipadamente dos débitos.
</p>

<p>
Cláusula 9ª. Ocorrendo a rescisão, o aluno será desligado da Escola (Nome) a partir do final do ano letivo, ficando obrigado a instituição de ensino, fornecer todos os documentos necessários para que o aluno efetive sua transferência.
</p>

<p><b>
DO PRAZO
</b></p>

<p>
Cláusula 10ª. Este contrato tem duração de xx meses, contando-se a partir de xx/xx/xx vigorando até xx/xx/xx.
</p>

<p><b>
CONDIÇÕES GERAIS
</b></p>

<p>
Cláusula 11ª. Fica condicionada a validade deste contrato à matrícula regular do aluno.
</p>

<p>
Cláusula 12ª. A não freqüência do aluno nas aulas não obsta ao pagamento das parcelas mensais à CONTRATADA.
</p>

<p>
Cláusula 13ª. É responsável o CONTRATANTE em adquirir o material didatico do aluno, sujerido pela instituição para que o mesmo acompanhe as aulas.
</p>

<p><b>
DO FORO
</b></p>

<p>
Cláusula 14ª. As partes elegem o foro da comarda de (Cidade), para dirimir quaisquer controvérsias oriundas do CONTRATO.
</p>

<p>
Por estarem assim justos e contratados, firmam o presente instrumento, em duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>

<br><br>
<p align="center">
<?php echo strtoupper($cidade_escola) .' '. $data_hoje ?>
</p>

<br><br>
<p align="center">
_________________________________________________________________
<br>(Nome e assinatura do Contratante)
</p>

<br><br>
<p align="center">
_________________________________________________________________
<br>
(Nome e assinatura da Contratada)
</p>

<br><br>
<p align="center">
_________________________________________________________________
<br>
(Nome, RG Testemunha)
</p>

<br><br>
<p align="center">
_________________________________________________________________
<br>
(Nome, RG Testemunha)
</p>

</div>
		

				<div class="footer">
		<p style="font-size:14px" align="center"><?php echo $rodape_relatorios ?></p> 
	</div>




				</body>
				</html>
