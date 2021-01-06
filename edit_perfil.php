<?php
//conexão bd - tetris_bd
include_once 'conexao.php';
$player = new conexao();
$conn  = $player->getConexao();

session_start(); //abrir a sessao

$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
$dtnasc = filter_input(INPUT_POST,'dtnasc',FILTER_SANITIZE_STRING);
$cpf = filter_input(INPUT_POST,'cpf',FILTER_SANITIZE_STRING);
$telefone = filter_input(INPUT_POST,'telefone',FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);

//fazendo update na tabela usuario
$result = "UPDATE usuario SET nome=:nome,data_nasc=:dtnasc,CPF=:cpf,telefone=:telefone,email=:email,username=:username,senha=:senha WHERE id_usuario = '".$_SESSION['id_usuario']."'";

    
$update = $conn->prepare($result);
$update->bindParam(':nome', $nome);
$update->bindParam(':dtnasc', $dtnasc);
$update->bindParam(':cpf', $cpf);
$update->bindParam(':telefone', $telefone);
$update->bindParam(':email', $email);
$update->bindParam(':username', $username);
$update->bindParam(':senha', $senha);

if($update->execute()){
    echo("Deu tudo certo");
    header("Location: rt.php");
}
else{
echo("Erro ao executar");
}
?>
