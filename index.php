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
    
<!--Forms Login-->
<main>
    <div id="container-forms">
        <form id="contact-form" class="form"  action="rt.html" method="POST">
            <h1 class="titulos-login text-center"><b>Acesse o sistema:</b></h1>
            <div class="forms">
                <div class="form-group">
                    <label class="form-label" for="name"><b>Username:</b></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu usuário aqui" required>
                </div>                            
                <div class="form-group">
                    <label class="form-label" for="password"><b>Senha:</b></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha aqui" required>
                </div>
                <h1 class="titulos-login-cadastro text-center"><a href="cadastro.php" style="color: black;"><b>Efetuar cadastro</b></a></h1>                            
                <div class="text-center">
                    <input class="btn btn-start-order" type="submit" value="Enviar" id="btn-form">
                </div>
            </div>
        </form>
       </div>
</main>

</body>
  
</html>