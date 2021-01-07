<?php
//conexão bd - tetris_bd
include_once 'conexao.php';
$conexao = new conexao();
$conn  = $conexao->getConexao();

session_start(); //abrir a sessao

$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
$telefone = filter_input(INPUT_POST,'telefone',FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);

//fazendo update na tabela usuario
$result = "UPDATE usuario SET nome=:nome,telefone=:telefone,email=:email,senha=:senha WHERE id_usuario = '".$_SESSION['id_usuario']."'";

    
$update = $conn->prepare($result);
$update->bindParam(':nome', $nome);//bind param recebe um valor como referencia
$update->bindParam(':telefone', $telefone);
$update->bindParam(':email', $email);
$update->bindParam(':senha', $senha);

if($update->execute()){//tratamento de erro apos a execução do execute()
    echo("Deu tudo certo");
    header("Location: rt.php");
}
else{
echo("Erro ao executar");
}
?>
