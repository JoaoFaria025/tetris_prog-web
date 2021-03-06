<?php
//conexão bd - tetris_bd
require_once 'conexao.php';
$player = new conexao();
$conn  = $player->getConexao();
?>

<!-- verificar sessão -->
<?php
    session_start(); //abrir a sessao
    if(!isset($_SESSION['id_usuario'])){ //verificar se o usuario esta logado
        header("location: index.php"); //redireciona para a pagina de login
        exit;
    } 
    $sql = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['id_usuario']."'";//exibe usuario de acordo com o ID dele
    $resultado = $conn->prepare($sql);
    $resultado->execute();
    $row = $resultado->fetch(PDO::FETCH_ASSOC);//imprimir o nome da coluna atraves do fetch e row recebe esse valor

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FIVEICON -->
    <link rel="shortcut icon" href="img/2726p.ico" />

    <!--CSS-->
    <link rel="stylesheet" href="css/style_rt.css">


    <!-- BS-->
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
    <title>Rooling Tetris</title>
</head>
<body style="background-color: #000000;">
    <audio id="inicio_game">
        <source src="Som//tetris_musica_principal.mp3" type="audio/mp3" />
     </audio>
     <audio id="linha_eliminada">
        <source src="Som/faustao.mp3" type="audio/mp3" />
     </audio>

    <!--NAV -->
    <nav class="navbar navbar-expand-lg " id="edit">
        <div class="container">
            <a class="navbar-brand h1 mb-0" href="#"><img src="img/unicamp-logo.png" alt="Unicamp logo" style="width: 250px;"></a>
            <button class="navbar-toggler navbar-light bg-light" type="button" data-toggle="collapse"
                data-target="#navbarSite">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSite">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active menu" href="#" style="color:#ff5e57;">Rolling
                            Tetris</a></li>
                    <li class="nav-item"><a class="nav-link active menu" href="ranking_global.php">Rankings</a>
                    </li>
                    <li class="nav-item"><a class="nav-link active menu" href="#myModal" data-toggle="modal"
                            data-target="#myModal">Editar Perfil</a></li>
                    <li class="nav-item"><a class="nav-link active menu" href="#sair_modal" data-toggle="modal"
                            data-target="#sair_modal">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>

 <main id="gameState" class="stoped main" >   
	<div class="grid">
        <audio id="audio">
            <source src="Som/damagecoda.mp3" type="audio/mp3" />
         </audio>
        <canvas id="rolling_tetris" class="game-board" height="200" width="400"></canvas>
		<div class="right-column">
			<div>
				<p><span class="info-player">Score:</span><span id="score" class="info-player-nums">0</span></p>
                <p><span class="info-player">Tempo de partida:</span> <span id="tempo" class="info-player-nums">0</span></p>
                <p><span class="info-player">Linhas eliminadas:</span><span id="linhaseliminadas" class="info-player-nums">0</span></p>
                <p><span class="info-player">Nível de dificuldade:</span><span id="dificuldade" class="info-player-nums">Fácil</span></p>
                <p><span class="info-player">Next piece:</span></p>
                <canvas id="Next_piece" class="next"></canvas>
			</div>	
            <button  class="play-button button"  data-toggle="modal" data-target="#escolher_game" id="play-btn" >Play</button>
             <button  data-toggle="modal" data-target="#reiniciar_jogo" id="restart-btn" class="restart-button button">Reiniciar Game</button>
		</div>
    </div>
    
     <!--JS TETRIS-->
     <script src="js/main.js"></script>
 </main>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="contact-form" class="form" action="edit_perfil.php" method="POST">
                        <h1 class="titulo"><b>Editar informações pessoais:</b></h1>
                        <div class="forms">
                            <div class="form-group">
                                <label class="form-label" for="name"><b>Nome:</b></label>
                                <input type="text" class="form-control" id="name" name="nome" value="<?php if(isset($row['id_usuario'])){ echo $row['nome']; }?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email"><b>Data de nascimento:</b></label>
                                <input  type="text" class="form-control" id="dtnasc" name="dtnasc" readonly="true"  value="<?php if(isset($row['id_usuario'])){ echo $row['data_nasc']; }?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name"><b>CPF:</b></label>
                                <input  type="text" class="form-control" id="cpf" name="cpf"  readonly="true" value="<?php if(isset($row['id_usuario'])){ echo $row['CPF']; }?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name"><b>Telefone:</b></label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="<?php if(isset($row['id_usuario'])){ echo $row['telefone']; }?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name"><b>Email:</b></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($row['id_usuario'])){ echo $row['email']; }?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name"><b>Username:</b></label>
                                <input  type="text" class="form-control" id="username" name="username" readonly="true" value="<?php if(isset($row['id_usuario'])){ echo $row['username']; }?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email"><b>Senha:</b></label>
                                <input type="text" class="form-control" id="senha" name="senha" value="<?php if(isset($row['id_usuario'])){ echo $row['senha']; }?>">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success"  value="send"
                                    style="margin:5px;"><b>Salvar</b></button>
                                    <button type="submit" class="btn btn-danger"  value="send"
                                        data-dismiss="modal"><b>Cancelar </b> </button>
                            </div>
                        </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>


    <!-- Modal SAIR -->
    <div class="modal fade" id="sair_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-danger  ">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Deseja sair?</h5>
                </div>
                <div class="modal-footer">
                <a  class="btn btn-success" href="logoff.php"> Confirmar</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

        <!-- MODAL Reiniciar o Jogo  -->
        <div class="modal fade" id="reiniciar_jogo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Deseja mesmo reiniciar o jogo?</h5>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-success"  onclick="reiniciar_jogo()">Confirmar</button> 
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>
      <!-- Modal Escolher Game -->
      <div class="modal fade" id="escolher_game" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger ">
            <h5 class="modal-title text-white"><b>Seja bem vindo ao Rolling Tetris!</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            Olá, para acessar o jogo selecione o tamanho do tetris desejado logo abaixo.<br> <b>Atenção: </b>Para reiniciar o jogo é só clicar no botão <i>Reiniciar Game</i> e logo em seguida clicar no botão <i>Play</i><br>
            <a href="https://drive.google.com/file/d/17luc1eAHSpiqHmqT0TFLGPT9_Yt60Y1T/view?usp=sharing">Acessar o manual do game</a>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger bg-danger text-white font-weight-bold" data-dismiss="modal" onclick="start_game(1)">Rolling Tetris (10x20)</button>
            <button type="button" class="btn btn-danger  bg-danger text-white font-weight-bold" data-dismiss="modal" onclick="start_game(2)">Rolling Tetris (22x44)</button>
            </div>
        </div>
        </div>
    </div>
    
    
        <!-- MODAL GAME OVER   -->
        <div class="modal fade" id="game_over" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="exampleModalLongTitle">Game over! Deseja Jogar Novamente?</h5>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-success"  onclick="reiniciar_jogo()" data-dismiss="modal"> Jogar novamente</button> 
                    <button type="button" class="btn btn-danger" onclick="reiniciar_jogo()">Cancelar e voltar ao menu.</button>
                </div>
                </div>
            </div>
            </div>
    
</body>


</html>
