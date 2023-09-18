<!DOCTYPE html>

<?php 

if (isset($_GET['mensagem'])){
$mensagem = $_GET['mensagem'];
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiro De Guerra 05-012</title>
    <link rel="icon" href="EB.png">
    <script src="https://kit.fontawesome.com/309120fd85.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


    <style>
        body {

            background-repeat: repeat;
            overflow-x: hidden;
        }
    </style>
</head>

<body background="camuflado.png">

    <?php
    require_once('Nav.php');
    ?>

<div class="container">
    <?php if (isset($mensagem)) { ?>
      <div class="alert alert-success" role="alert">
        <?php echo $mensagem ?>
      </div>
    <?php } ?>
  </div>

    <center>
        <div class="container" style="position: relative; top: 10vh;">
            <div class="card w-50 bg-dark text-light" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">
                        <p>Bem-vindo ao Tiro de Guerra - Cadastro de Atiradores!</p>
                    </h5>
                    <p class="card-text" style="text-align:center;">O Tiro de Guerra desempenha um papel fundamental na formação e treinamento de jovens brasileiros, e nossa missão é simplificar e aprimorar o processo de registro e acompanhamento de atiradores. Nossa plataforma permite que comandantes, instrutores e atiradores acessem e atualizem informações de forma fácil e segura, contribuindo para a excelência do treinamento militar.
                    </p>
                    <p>Com dedicação,</p>
                    <p>Monitor Meireles.</p>
                </div>
            </div>
    </center>


</body>

</html>