<?php 

require_once("../conexao.php"); 
@session_start();

$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$status = $_POST['status'];

$html = file_get_contents($url."rel/rel_mov_html.php?dataInicial=$dataInicial&dataFinal=$dataFinal&status=$status");
echo $html;


?>