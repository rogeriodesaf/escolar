<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$endereco = $_POST['endereco'];
$sexo = $_POST['sexo'];
$data_nasc = $_POST['data_nasc'];
$responsavel = $_POST['responsavel'];

$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];
$id = $_POST['txtid2'];


//RECUPERAR A DATA PARA VERIFICAR SE O ALUNO É MENOR DE IDADE
$data_18 = date("Y-m-d",strtotime(date("Y-m-d")."-18 year"));
if($responsavel == ""){
	if($data_nasc > $data_18){
		echo 'O Aluno é menor de Idade, Preencha o CPF do Responsável!';
		exit();
	}
}


//VERIFICAR SE O RESPONSÁVEL ESTÁ CADASTRADO
if($responsavel != ""){
$query = $pdo->query("SELECT * FROM responsaveis where cpf = '$responsavel' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg == 0){
		echo 'O CPF do Responsável não foi encontrado, provavelmente não está Cadastrado!';
		exit();
	}
}

if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}

if($email == ""){
	echo 'O email é Obrigatório!';
	exit();
}

if($cpf == ""){
	echo 'O CPF é Obrigatório!';
	exit();
}





//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $cpf){
	$query = $pdo->query("SELECT * FROM alunos where cpf = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O CPF já está Cadastrado!';
		exit();
	}
}


//VERIFICAR SE O REGISTRO COM MESMO EMAIL JÁ EXISTE NO BANCO
if($antigo2 != $email){
	$query = $pdo->query("SELECT * FROM alunos where email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O Email já está Cadastrado!';
		exit();
	}
}



//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
$caminho = '../../img/alunos/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
    $imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}


if($id == ""){
	$res = $pdo->prepare("INSERT INTO alunos SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone, foto = '$imagem', sexo = :sexo, data_nascimento = :data_nascimento, responsavel = :responsavel, data_cadastro = curDate()");	

	$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, nivel = :nivel");	
	$res2->bindValue(":senha", '123');
	$res2->bindValue(":nivel", 'aluno');

}else{
	if($imagem == "sem-foto.jpg"){
		$res = $pdo->prepare("UPDATE alunos SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone, sexo = :sexo, data_nascimento = :data_nascimento, responsavel = :responsavel WHERE id = '$id'");
	}else{
		$res = $pdo->prepare("UPDATE alunos SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone, foto = '$imagem', sexo = :sexo, data_nascimento = :data_nascimento, responsavel = :responsavel WHERE id = '$id'");
	}
	

	$res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email WHERE cpf = '$antigo'");	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":endereco", $endereco);
$res->bindValue(":sexo", $sexo);
$res->bindValue(":data_nascimento", $data_nasc);
$res->bindValue(":responsavel", $responsavel);

$res2->bindValue(":nome", $nome);
$res2->bindValue(":cpf", $cpf);
$res2->bindValue(":email", $email);


$res->execute();
$res2->execute();

echo 'Salvo com Sucesso!';

?>