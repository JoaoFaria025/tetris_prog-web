<?php
//conexão bd - tetris_bd
require_once 'conexao.php';
$player = new conexao();
$player->getConexao();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FIVEICON -->
    <link rel="shortcut icon" href="img/2726p.ico"/>

    <!--CSS-->
    <link rel="stylesheet" href="css/style_cad.css">

    <!--BS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   
    <!--FONT-->
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">

    <title>Cadastro RT</title>
</head>
<body style="background-image: url(img/Endless-Constellation_cad.svg);">

    <!--Forms cadastro-->
    <main>
        <div id="container-forms">
            <form id="contact-form" class="form"  action="index.html" method="POST">
                <h1 class="titulos-login text-center"><b>Efetuar cadastro:</b></h1>
                <div class="forms">
                    <div class="form-group">
                        <label class="form-label" for="name"><b>Nome:</b></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome aqui" required>
                    </div>                            
                    <div class="form-group">
                        <label class="form-label" for="email"><b>Data de nascimento:</b></label>
                        <input type="date" class="form-control" id="dtnasc" name="dtnasc" required>
                    </div>        
                    <div class="form-group">
                        <label class="form-label" for="name"><b>CPF:</b></label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                    </div>               
                    <div class="form-group">
                        <label class="form-label" for="name"><b>Telefone:</b></label>
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(00)0000-0000" required>
                    </div>  
                    <div class="form-group">
                        <label class="form-label" for="name"><b>Email:</b></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite o seu email aqui" required>
                    </div>            
                    <div class="form-group">
                        <label class="form-label" for="name"><b>Username:</b></label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Digite seu usuário aqui" required>
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="email"><b>Senha:</b></label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha aqui" required>
                    </div>
                    <div class="text-center">
                     <input class="btn btn-start-order" type="submit" value="Enviar" id="btn-form">
                    </div>
                </div>
            </form>
           </div>
    </main>
    
</body>
</html>