<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome'];

$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}


//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $nome){
	$query = $pdo->query("SELECT * FROM disciplinas where nome = '$nome' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'A Disciplina já está Cadastrada!';
		exit();
	}
}



if($id == ""){
	$res = $pdo->prepare("INSERT INTO disciplinas SET nome = :nome");	


}else{
	$res = $pdo->prepare("UPDATE disciplinas SET nome = :nome WHERE id = '$id'");

	
	
}

$res->bindValue(":nome", $nome);


$res->execute();


echo 'Salvo com Sucesso!';

?>