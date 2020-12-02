<?php 

$query_r = $pdo->query("SELECT * FROM pgto_matriculas where id = '" . $id_pgto . "' ");
    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
    $valor_mat = $res_r[0]['valor'];
    $id_mat = $res_r[0]['matricula'];

    $pdo->query("UPDATE pgto_matriculas SET pago = 'Sim' WHERE id = '$id_pgto'");

    $pdo->query("INSERT movimentacoes SET tipo = 'Entrada', descricao = 'Pagamento Mensalidade', valor = '$valor_mat', funcionario = '$cpf_usuario', data = curDate(), mensalidade = 'Sim' ");

 ?>