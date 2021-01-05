<?php
//conexão bd - tetris_bd
require_once 'conexao.php';
$player = new conexao();
$conn  = $player->getConexao();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- FIVEICON -->
  <link rel="shortcut icon" href="img/2726p.ico" />

  <!--CSS-->
  <link rel="stylesheet" href="css/style_rank_global.css">

  <!--BS-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <!--FONT-->
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">

  <!--Ajax, Jquery, Js-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
    integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
  </script>

  <!-- Title-->
  <title>Rankings</title>
</head>

<body style="background-image: url(img/Endless-Constellation.svg);">

  <!--NAV -->
  <nav class="navbar navbar-expand-lg " id="edit">
    <div class="container">
      <a class="navbar-brand h1 mb-0" href="rt.php"><img src="img/unicamp-logo.png" alt="Unicamp logo"
          style="width: 250px;"></a>
      <button class="navbar-toggler navbar-light bg-light" type="button" data-toggle="collapse"
        data-target="#navbarSite">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSite">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link active menu" href="rt.php">Rolling Tetris</a></li>
          <li class="nav-item"><a class="nav-link active menu" href="#" style="color:#ff5e57;">Rankings</a></li>
          <li class="nav-item"><a class="nav-link active menu" href="#sair_modal" data-toggle="modal"
              data-target="#sair_modal">Sair</a></li>
        </ul>
      </div>
    </div>
  </nav>
   <!--RANKING JOGADOR-->
   <section>
    <div class="titulo-rank text-center">
        <h2 class="titulos"><b>RANKING JOGADOR</b></h2>
        <hr class="hr">
    </div>
    <div class="rank bg-dark">
   <table id="table_rank" class="table">
   <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Pontuação</th>
                    <th scope="col">Nível atingido</th>
                    <th scope="col">Tempo de duraçao</th>
                </tr>
   </thead>


   <tbody class="text-white">

        <?php
        //MUDAR O USERNAME_USU PARA O ATUAL!
      $result_msg = "SELECT * FROM ranking WHERE username_usu = 'cORSI' ORDER BY id_ranking ASC";
      $test =  $conn->prepare($result_msg);
      $test->execute();
       while ($row_msg_cont = $test->fetch(PDO::FETCH_ASSOC)){
         ?>
                 <tr>
                    <th scope="row"><?php echo $row_msg_cont['id_ranking'].'<br>'; ?></th>
                    <td><?php echo $row_msg_cont['pontuacao_usu'].'<br>'; ?></td>
                    <td><?php echo $row_msg_cont['nivel_atingido'].'<br>'; ?></td>
                    <td><?php echo $row_msg_cont['tempo_partida'].'<br>'; ?></td>
                </tr>

      <?php
       }     
 ?>      
            </tbody>
        </table>
    </div>
</section>

  <!--RANKING GLOBAL-->
  <main>
    <div class="titulo-rank text-center">
      <h1 class="titulos"><b>RANKING GLOBAL</b></h1>
      <hr class="hr">
    </div>
    <table class="table bg-dark" id="table_rank_1">
      <thead>
        <tr>
          <th scope="col">Posição</th>
          <th scope="col">Usuário</th>
          <th scope="col">Pontuação</th>
          <th scope="col">Nível Máximo atingido</th>
        </tr>
      </thead>
      <tbody class="text-white">


          <?php
          $count = 1;
          $result_msg = "SELECT * FROM ranking ORDER BY pontuacao_usu DESC LIMIT 10";
          $test =  $conn->prepare($result_msg);
          $test->execute();
          while ($row_msg_cont = $test->fetch(PDO::FETCH_ASSOC)){
          ?>
                  <tr>
                      <th scope="row"><?php echo $count; ?></th>
                      <td><?php echo $row_msg_cont['username_usu'].'<br>'; ?></td>
                      <td><?php echo $row_msg_cont['pontuacao_usu'].'<br>'; ?></td>
                      <td><?php echo $row_msg_cont['nivel_atingido'].'<br>'; ?></td>
                  </tr>
            
                

          <?php
          $count++;
          }     
          ?>      
        <tr class="bg-dark">
          <th scope="row" class="posicao_atual">Sua posição atual no Ranking:</th>
          <?php

          //MUDAR O USERNAME_USU PARA O ATUAL!
          $result_atual = "SELECT * FROM ranking WHERE username_usu = 'cORSI' ORDER BY pontuacao_usu DESC LIMIT 1";
          $resultado =  $conn->prepare($result_atual);
          $resultado->execute();
          while ($row_msg_atual = $resultado->fetch(PDO::FETCH_ASSOC)){
            $pontuacao_usu = $row_msg_atual['pontuacao_usu'];
            //MUDAR O USERNAME_USU PARA O ATUAL!
            $verifica_posicao = "SELECT * FROM ranking WHERE username_usu = 'cORSI' and pontuacao_usu ='".$pontuacao_usu."' LIMIT 1";
            $resultado_atual =  $conn->prepare($verifica_posicao);
            $resultado_atual->execute();
            $array_valores =  $resultado_atual->fetch(PDO::FETCH_ASSOC);

            $count_novo = 1;
            $count_atual = 0;

            $query_verifica = "SELECT * FROM ranking ORDER BY pontuacao_usu DESC LIMIT 10";
            $valor_rankings =  $conn->prepare($query_verifica);
            $valor_rankings->execute();

            while ($result_query= $valor_rankings->fetch(PDO::FETCH_ASSOC)){
              if($result_query['pontuacao_usu'] == $array_valores['pontuacao_usu']){
                $count_atual =  $count_novo;
                break;

              }

              else{
              $count_novo++;
              }

              }     
         
          ?>
           
                       <td colspan="3" class="posicao_atual"><?php  echo $count_atual;?></td>
                           
          <?php
          }     
          ?> 

         
        </tr>
      </tbody>
    </table>
  </main>

  <!--INFO-BOOSTRAP-->
  <footer class="text-white">
    <div class="text-center">Utilizou-se do Bootstrap como framework de desenvolvimento</div>
  </footer>

  <!-- Modal SAIR -->
  <div class="modal fade" id="sair_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Deseja sair?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>