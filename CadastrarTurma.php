<?php
// Conecta ao banco de dados do TG)
$conexao = mysqli_connect('localhost', 'root', '', 'tg_05-012');


// Verifica se houve um erro de conexão
if (!$conexao) {
  die('Erro de conexão: ' . mysqli_connect_error());
}

// Codigo do envio dos dados ao banco.
if (isset($_POST['cadastrar'])) {

  $slq_2 = "SELECT * from tb_turma";
  $postar = mysqli_query($conexao, $slq_2);

  //2-receber os valores para inserir
  $NRa = $_POST['AnoT'];
  $NomeC = $_POST['InstrutorC'];

  //3-preparar a SQL com os dados a serem inseridos
  $sql = "insert into tb_turma (AnoTurma, InstrutorC)
                values ('$NRa', '$NomeC')";

  //executar a SQL
  mysqli_query($conexao, $sql);

  
  //Mensagem de Sucesso
  header("Location: index.php?mensagem=Turma cadastrada com sucesso!");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="EB.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

  <title>Cadastrar Atirador</title>

  <style>
  
  body {

    background-repeat: repeat;
    overflow-x: hidden;
}



</style>
</head>

<body background="camuflado.png">

  <?php
  require_once 'Nav.php';
  ?>

  <div class="container">
    <?php if (isset($mensagem)) { ?>
      <div class="alert alert-success" role="alert">
        <?php echo $mensagem ?>
      </div>
    <?php } ?>
  </div>

  <br>
  <br>
  <div class="container text-dark">
    <form method="post" class="row g-3 bg-dark text-light shadow-none p-3 mb-5 rounded" enctype="multipart/form-data">
    <center>
      <h1>Cadastro de Turma</h1>
    </center>
    <br>  
    <div class="col-md-3">
        <label for="AnoT" class="form-label">Ano da turma</label>
        <input name="AnoT" type="text" class="form-control" id="AnoT" placeholder="Ex: 2023" required>
      </div>
      <div class="col-md-3">
        <label for="InstrutorC" class="form-label">Instrutor Chefe</label>
        <input name="InstrutorC" type="text" class="form-control" id="InstrutorC" placeholder="Ex: St. Paulo..." required>
      </div>
      <br>
      <div class="container">
        <button type="submit" class="btn btn-primary" name="cadastrar" onclick="return confirm('Confirma cadastro?')">Cadastrar</button>
        <a href="index.php" class="btn btn-warning">Voltar</a>
      </div>
    </form>
  </div>

</body>
<?php
$conexao->close();
?>
</html>