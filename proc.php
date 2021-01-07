<?php
//conexão bd - tetris_bd
include_once 'conexao.php';
$conexao = new conexao();
$conn  = $conexao->getConexao();

$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
$dtnasc = filter_input(INPUT_POST,'dtnasc',FILTER_SANITIZE_STRING);
$cpf = filter_input(INPUT_POST,'cpf',FILTER_SANITIZE_STRING);
$telefone = filter_input(INPUT_POST,'telefone',FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);

  $result = "INSERT INTO usuario (nome,data_nasc,CPF,telefone,email,username,senha) 
  VALUES (:nome,:dtnasc,:cpf,:telefone,:email,:username,:senha)";
    
$insert = $conn->prepare($result);
$insert->bindParam(':nome', $nome);
$insert->bindParam(':dtnasc', $dtnasc);
$insert->bindParam(':cpf', $cpf);
$insert->bindParam(':telefone', $telefone);
$insert->bindParam(':email', $email);
$insert->bindParam(':username', $username);
$insert->bindParam(':senha', $senha);

if($insert->execute()){
    echo("foi");
    header("Location: index.php");
}
else{
echo("n foi");
}
?>