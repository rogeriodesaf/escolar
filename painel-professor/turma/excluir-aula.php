<?php 
require_once("../../conexao.php"); 

$id = $_POST['idaula'];


$pdo->query("DELETE FROM aulas WHERE id = '$id'");

echo 'Excluído com Sucesso!';

?>