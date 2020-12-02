<?php 

require_once("../conexao.php"); 
@session_start();


$id_turma = $_GET['id_turma'];
$id_aluno = $_GET['id_aluno'];

$html = file_get_contents($url."rel/certificado_html.php?id_turma=$id_turma&id_aluno=$id_aluno");
echo $html;


?>