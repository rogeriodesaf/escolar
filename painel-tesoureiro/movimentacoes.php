<?php 
$pag = "pagar";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'tesoureiro'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Funcionário</th>
                        <th>Data</th>
                        
                        
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM movimentacoes  order by id desc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $descricao = $res[$i]['descricao'];
                  $valor = $res[$i]['valor'];
                  $data = $res[$i]['data'];
                  $tipo = $res[$i]['tipo'];

                  $funcionario = $res[$i]['funcionario'];
                  $id = $res[$i]['id'];

                  $valor = number_format($valor, 2, ',', '.');
                  $data = implode('/', array_reverse(explode('-', $data)));

                  $query2 = $pdo->query("SELECT * FROM usuarios where cpf = '$funcionario' ");
                 $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                 $nome_func = $res2[0]['nome'];

                 if($tipo == 'Entrada'){
                    $classe = 'text-success';
                 }else{
                    $classe = 'text-danger';
                 }

                  ?>


                  <tr>
                    <td>
                        <i class="fas fa-square mr-1 <?php echo $classe ?>"></i>
                        <?php echo $tipo ?>
                            
                        </td>
                    <td><?php echo $descricao ?></td>
                    <td><?php echo $valor ?></td>
                     <td><?php echo $nome_func ?></td>
                    <td><?php echo $data ?></td>

                  
               </tr>
           <?php } ?>





       </tbody>
   </table>
</div>
</div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable').dataTable({
            "ordering": false
        })

    });
</script>



