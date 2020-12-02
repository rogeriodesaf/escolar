<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];


$pdo->query("DELETE FROM contas_pagar WHERE id = '$id'");


echo 'Excluído com Sucesso!';

?>