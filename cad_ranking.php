<?php
//conexão bd - tetris_bd
include_once 'conexao.php';
$player = new conexao();
$conn  = $player->getConexao();

$pontuacao_usu = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
$nivel_atingido = filter_input(INPUT_POST,'dtnasc',FILTER_SANITIZE_STRING);
$tempo_partida = filter_input(INPUT_POST,'cpf',FILTER_SANITIZE_STRING);
$username_usu = filter_input(INPUT_POST,'telefone',FILTER_SANITIZE_STRING);

$result = "INSERT INTO ranking (pontuacao_usu,nivel_atingido,tempo_partida,username_usu) 
  VALUES (:pont,:nivel,:tempo,:user)";
  
$insert = $conn->prepare($result);
$insert->bindParam(':pont', $pont);
$insert->bindParam(':nivel', $nivel);
$insert->bindParam(':tempo', $tempo);
$insert->bindParam(':user', $user);


if($insert->execute()){
    echo("foi");
    header("Location: index.php");
}
else{
echo("n foi");
}


?>