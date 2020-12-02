<?php 

require_once("../conexao.php"); 
@session_start();

$id_turma = $_GET['id_turma'];
$id_aluno = $_GET['id_aluno'];


$query_r = $pdo->query("SELECT * FROM alunos where id = '$id_aluno' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$nome_aluno = $res_r[0]['nome'];
$cpf_aluno = $res_r[0]['cpf'];
$responsavel = $res_r[0]['responsavel'];
$endereco_aluno = $res_r[0]['endereco'];
$telefone_aluno = $res_r[0]['telefone'];



$query_r = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$disciplina = $res_r[0]['disciplina'];
$data_inicio = $res_r[0]['data_inicio'];
$data_final = $res_r[0]['data_final'];
$valor = $res_r[0]['valor_mensalidade'];


$query_r = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$nome_curso = $res_r[0]['nome'];


$hoje = date('Y-m-d');
$encoding = mb_internal_encoding();
$data2 = implode('/', array_reverse(explode('-', $hoje)));
 ?>



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>

 @page {
            margin: 0px;
            
        }


.imagem {
width: 100%;
}	

.nome-curso {
position: absolute;
margin-top: 240px;
text-align:center;
color:#913610;
font-size:39px;
width:100%;

}

.nome-aluno {
position: absolute;
margin-top: 330px;
text-align:center;
color:#000;
font-size:31px;
width:100%;

}


.descricao {
position: absolute;
margin-top: 415px;
text-align:center;
color:#473e3a;
font-size:19px;
width:100%;

}


.carga {
position: absolute;
margin-top: 500px;
text-align:center;
color:#473e3a;
font-size:25px;
width:100%;

}


.cpf {
position: absolute;
margin-top: 534px;
text-align:center;
color:#473e3a;
font-size:15px;
width:100%;

}



.tecnologias {
position: absolute;
margin-top: 470px;
text-align:center;
color:#737373;
font-size:14px;
width:100%;

}




</style>


<body>

<div class="nome-curso"> CURSO DE <?php echo mb_strtoupper($nome_curso, $encoding); ?></div>
<div class="nome-aluno"> <b><?php echo mb_strtoupper($nome_aluno, $encoding); ?></b></div>
<div class="descricao"> PARABÉNS PELA CONCLUSÃO COM EXCELÊNCIA DO TREINAMENTO <br><span class="text-warning"><?php echo mb_strtoupper($nome_curso, $encoding); ?></span> MINISTRADO PELA <?php echo mb_strtoupper($nome_escola) ?></div>

<div class="carga"> <?php echo $carga_horaria_cert; ?> Horas - Emitido em <?php echo $data2; ?></div>
<div class="cpf"> Documento do Aluno : <?php echo $cpf_aluno; ?> </div>

<img class="imagem" src="http://portal.hugocursos.com.br/certificados/certificado-fundo.jpg">



</body>


