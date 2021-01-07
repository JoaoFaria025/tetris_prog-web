<?php
session_start();
 if (isset($_POST)){

        require_once 'conexao.php';
        $conexao= new conexao();
        $conn  = $conexao->getConexao();

        $codigo_usuario = $_SESSION['id_usuario']; //id_usuario DO USUÁRIO
        $cst = $conn->prepare("SELECT * from usuario WHERE id_usuario=:usu_id");
        $cst->bindParam(":usu_id", $codigo_usuario, PDO::PARAM_INT);
        $cst->execute();
        $resultado = $cst->fetch(); // SALVA OS DADOS DO BD NA FORMA DE UM ARRAY.
        $jogador_atual = $resultado['username'];


        $score = $_POST['score'];
        $dificuldade = $_POST['dificuldade'];
        $tempo_partida = $_POST['tempo_partida'];

        $cst = $conn->prepare("INSERT INTO ranking (id_ranking, pontuacao_usu, nivel_atingido, tempo_partida, username_usu) VALUES (NULL, '$score', '$dificuldade', '$tempo_partida', '$jogador_atual')");
        $cst->execute();

}
else{
   echo 'aa';
}
