<?php 

$nome_escola = "Escola Freitas";
$url = "http://localhost/escolar/";
$endereco_escola = "Rua Alameda Campos, 157, Belo Horizonte";
$telefone_escola = "(31)97527-5084";
$email_adm = 'hvfadvocacia@gmail.com';
$rodape_relatorios = "Desenvolvido por Hugo Vasconcelos - Portal Hugo Cursos";
$cnpj_escola = '26.100.560/0000-50';
$cidade_escola = 'Belo Horizonte';


//VARIAVEIS DO BANCO DE DADOS LOCAL
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'escolar';


//VARIAVEIS GLOBAIS
$pgto_boleto = 'Sim';  //DEIXAR SIM PARA PAGAMENTOS COM BOLETO OU CARNE, APENAS PARA DAR A POSSIBILIDADE DO TESOUREIRO CARREGAR OS ARQUIVOS

$media_porcentagem_presenca = 70; //70 define que a média limite para presença é de 70%;

$media_pontos_minimo_aprovacao = 60; // o aluno vai precisar de no minimo 60 pontos para aprovação no curso

$maximo_pontos_disciplina = 100; // Maximo de pontos possiveis para distribuir em cada disciplina

$carga_horaria_cert = 250; //TEMPO EM HORAS DOS CURSOS

 ?>