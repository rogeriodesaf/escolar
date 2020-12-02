<?php 
require_once("../../conexao.php"); 
@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario'];
$id_pgto = $_POST['id'];

require_once("../baixar-mensalidade.php"); 

echo 'Baixado com Sucesso!';

?>