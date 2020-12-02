<?php 
require_once("../../conexao.php"); 
@session_start();
$cpf_usuario = $_SESSION['cpf_usuario'];

$id = $_POST['id'];


$query = $pdo->query("SELECT * FROM contas_pagar where id = '$id'  ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$descricao = 'Pagamento ' .$res[0]['descricao'];
$valor = $res[0]['valor'];

$pdo->query("UPDATE contas_pagar SET pago = 'Sim' WHERE id = '$id'");

//INSERIR NAS MOVIMENTAÇÕES
 $pdo->query("INSERT movimentacoes SET tipo = 'Saída', descricao = '$descricao', valor = '$valor', funcionario = '$cpf_usuario', data = curDate() ");

echo 'Baixado com Sucesso!';

?>