<?php
session_start();
 if (isset($_POST)){

        require_once 'conexao.php';
        $conexao= new conexao();
        $conn  = $conexao->getConexao();

        $jogador_atual = $_SESSION['username'] ;

        $score = $_POST['score'];
        $dificuldade = $_POST['dificuldade'];
        $tempo_partida = $_POST['tempo_partida'];

        $cst = $conn->prepare("INSERT INTO ranking (id_ranking, pontuacao_usu, nivel_atingido, tempo_partida, username_usu) VALUES (NULL, '$score', '$dificuldade', '$tempo_partida', '$jogador_atual')");
        $cst->execute();

}
else{
   echo 'aa';
}
