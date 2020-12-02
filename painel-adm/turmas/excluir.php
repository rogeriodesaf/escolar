<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

//VERIFICAR SE TEM ALUNOS NA TURMA PARA RESTRINGIR EXCLUSÃO
$query = $pdo->query("SELECT * FROM matriculas WHERE turma = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	echo 'Essa turma possui alunos matriculados, remova os alunos para depois excluir!';
	exit();
}

$pdo->query("DELETE FROM turmas WHERE id = '$id'");


echo 'Excluído com Sucesso!';

?>