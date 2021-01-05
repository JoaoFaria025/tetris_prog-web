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
    <link rel="shortcut icon" href="img/2726p.ico"/>
    <!--CSS-->
    <link rel="stylesheet" href="css/style.css">
    <!--BS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   
    <!--FONT-->
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">


    <title>Rolling Tetris</title>
</head>
<body style="background-image: url(img/Endless-Constellation.svg);">
    
<!--Form Login-->
<main>
    <div id="container-forms">
        <form id="contact-form" class="form"  action="index.php" method="POST">
            <h1 class="titulos-login text-center"><b>Acesse o sistema:</b></h1>
            <div class="forms">
                <div class="form-group">
                    <label class="form-label" for="name"><b>Username:</b></label>
                    <input type="text" class="form-control" id="name" name="username" placeholder="Digite seu usuário aqui" maxlength="20" required>
                </div>                            
                <div class="form-group">
                    <label class="form-label" for="password"><b>Senha:</b></label>
                    <input type="password" class="form-control" id="password" name="senha" placeholder="Digite sua senha aqui" maxlength="200" required>
                </div>
                <h1 class="titulos-login-cadastro text-center"><a href="cadastro.php" style="color: black;"><b>Efetuar cadastro</b></a></h1>                            
                <div class="text-center">
                    <input class="btn btn-start-order" type="submit" value="Enviar" id="btn-form">
                </div>
            </div>
        </form>
       </div>
</main>

<!-- Login -->
<?php
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $senha = $_POST['senha'];
        //verificar username e senha (se estao cadastrados no banco de dados)
        $q = "SELECT id_usuario FROM usuario WHERE username = :user AND senha = :s";
        $sql = $conn->prepare($q);
        $sql->bindValue(":user",$username); //substitui pelo username que veio como parametro
        $sql->bindValue(":s",$senha); //substitui pela senha que veio como parametro
        if($sql->execute()){
            if($sql->rowCount() == 1){
                $info = $sql->fetch(); //recebe os dados e transforma em um array
                session_start(); //criar uma sessao
                $_SESSION['id_usuario'] = $info['id_usuario']; //id do usuario logado esta armazenado em uma sessao
                header('Location: rt.php'); //acesso ao sistema (area privada)
                exit();
            }
            else{
                ?>
                <br><div class="text-center">
                    <h5 style="color: white;">Usuário e/ou senha inválidos.
                </div>
                <?php
            }
        }
    }
?>

</body>
  
</html>