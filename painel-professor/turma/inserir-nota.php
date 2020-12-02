<?php 
require_once("../../conexao.php"); 

$nota = $_POST['nota'];
$descricao = $_POST['descricao'];
$nota_max = $_POST['nota-max'];
$turma = $_POST['turma'];
$periodo = $_POST['periodo'];
$aluno = $_POST['aluno'];

if($descricao == ""){
	echo 'O descrição é Obrigatória!';
	exit();
}

if($nota == ""){
	echo 'O nota é Obrigatória!';
	exit();
}

if($nota_max == ""){
	echo 'O nota máxima é Obrigatória!';
	exit();
}

if($nota > $nota_max){
	echo 'A nota do aluno não pode ser maior que a nota distribuida pelo trabalho / prova!';
	exit();
}


$res = $pdo->prepare("INSERT INTO notas SET turma = :turma, nota = :nota, descricao = :descricao, periodo = :periodo, aluno = :aluno, nota_max = :nota_max");	

	
$res->bindValue(":nota", $nota);
$res->bindValue(":descricao", $descricao);
$res->bindValue(":nota_max", $nota_max);
$res->bindValue(":turma", $turma);
$res->bindValue(":periodo", $periodo);
$res->bindValue(":aluno", $aluno);

$res->execute();


echo 'Salvo com Sucesso!';

?>