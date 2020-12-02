<?php 
require_once("../../conexao.php"); 
@session_start();
$cpf_usuario = $_SESSION['cpf_usuario'];

$descricao = $_POST['descricao'];
$vencimento = $_POST['vencimento'];
$valor = $_POST['valor'];


$valor = str_replace(',', '.', $valor);

$id = $_POST['txtid2'];

if($descricao == ""){
	echo 'A descrição é Obrigatória!';
	exit();
}

if($valor == ""){
	echo 'O valor é Obrigatório!';
	exit();
}

if($vencimento == ""){
	echo 'O Vencimento é Obrigatório!';
	exit();
}



//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
$caminho = '../../img/contas/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
    $imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}


if($id == ""){
	$res = $pdo->prepare("INSERT INTO contas_pagar SET descricao = :descricao, valor = :valor, data_venc = :vencimento, arquivo = '$imagem', funcionario = :funcionario, data = curDate(), pago = 'Não'");	

	
}else{
	if($imagem == "sem-foto.jpg"){
		$res = $pdo->prepare("UPDATE contas_pagar SET descricao = :descricao, valor = :valor, data_venc = :vencimento, funcionario = :funcionario, data = curDate(), pago = 'Não' WHERE id = '$id'");
	}else{
		$res = $pdo->prepare("UPDATE contas_pagar SET descricao = :descricao, valor = :valor, data_venc = :vencimento, arquivo = '$imagem', funcionario = :funcionario, data = curDate(), pago = 'Não' WHERE id = '$id'");
	}
	

	
	
}

$res->bindValue(":descricao", $descricao);
$res->bindValue(":valor", $valor);
$res->bindValue(":vencimento", $vencimento);
$res->bindValue(":funcionario", $cpf_usuario);


$res->execute();


echo 'Salvo com Sucesso!';

?>