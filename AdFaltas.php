<?php
require("config.php");
// Conecta ao banco de dados do TG)
$Nome = "select * from tb_atiradores where ID_ATDR = :id";
$consulta = $conn->prepare($Nome);
$consulta->bindParam(":id", $_GET['id']);
$consulta->execute();
$linha = $consulta->fetch(PDO::FETCH_ASSOC);
$conexao = mysqli_connect('localhost', 'root', '', 'tg_05-012');

$id_turma = $_GET['fk_ID_turma']; //pega o id da URL para mostrar o usuário
$id = $_GET['id'];
// Verifica se houve um erro de conexão
if (!$conexao) {
  die('Erro de conexão: ' . mysqli_connect_error());
}

// Codigo do envio dos dados ao banco.
if (isset($_POST['cadastrar'])) {

  $diretorio = "Upload/";
  $Arquivo = $diretorio . $_FILES['Arquivo']['name'];
  //2-receber os valores para inserir
  $Atirador = $_POST['Atirador'];
  $DataF = $_POST['DataF'];
  $MotivoF = $_POST['MotivoF'];
  $numero_mes = date('m', strtotime($DataF));

  move_uploaded_file($_FILES['Arquivo']['tmp_name'], $Arquivo);

  if (isset($_POST['FaltaJ'])) {
    $PontoF = 2;
    $FaltaJ = "Justificada";
  } else {
    $PontoF = 4;
    $FaltaJ = "Não Justificada";
  }

  switch ($numero_mes) {
    case 3:
      $nome_mes = 'Março';
      break;
    case 4:
      $nome_mes = 'Abril';
      break;
    case 5:
      $nome_mes = 'Maio';
      break;
    case 6:
      $nome_mes = 'Junho';
      break;
    case 7:
      $nome_mes = 'Julho';
      break;
    case 8:
      $nome_mes = 'Agosto';
      break;
    case 9:
      $nome_mes = 'Setembro';
      break;
    case 10:
      $nome_mes = 'Outubro';
      break;
    case 11:
      $nome_mes = 'Novembro';
      break;
    default:
      $nome_mes = '';
      break;
  }
  //3-preparar a SQL com os dados a serem inseridos
  $sql = "insert into tb_faltas (MesFalta, MotivoFalta, DiaFalta, fk_ID_ATDR, PontoFaltas, ArquivoC, TotalF, JustificativaF)
                values ('$nome_mes', '$FaltaJ', '$DataF', '$id', '$PontoF', '$Arquivo', TotalF + '$PontoF', '$MotivoF')";

  //executar a SQL
  mysqli_query($conexao, $sql);


  //Mensagem de Sucesso
  header("Location: Faltas.php?mensagem=Falta adicionada com sucesso!&fk_ID_turma=$id_turma");
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

  <title>Adicionar faltas</title>

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
    <form method="post" class="row g-2 bg-dark text-light shadow-none p-3 mb-3 rounded" enctype="multipart/form-data">
      <center>
        <h1>Adicionar faltas</h1>
      </center>
      <br>
      <div class="col-md-3">
        <label for="Atirador" class="form-label">Atirador</label>
        <input name="Atirador" value="<?= $linha['NomeG'] ?>" type="text" class="form-control" id="Atirador" placeholder="Nome ou número..." required>
      </div>
      <div class="col-md-3">
        <label for="Arquivo" class="form-label">Arquivo</label>
        <input name="Arquivo" type="file" class="form-control" id="Arquivo">
      </div>
      <div class="col-md-3">
        <label for="DataF" class="form-label">Dia da falta</label>
        <input name="DataF" type="date" class="form-control" id="DataF" required>
      </div>
      <div class="container">
      <div class="col-md-3">
        <label for="exampleFormControlTextarea1" class="form-label">Motivo</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="MotivoF" placeholder="Motivo da falta..."></textarea>
      </div>
      <br>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="FaltaJ" role="switch" id="flexSwitchCheckDefault">
          <label class="form-check-label" for="flexSwitchCheckDefault">Falta Justificada</label>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="cadastrar" onclick="return confirm('Confirma falta?')">Cadastrar</button>
        <a href="Faltas.php?fk_ID_turma=<?= $id_turma ?>" class="btn btn-warning">Voltar</a>
      </div>
    </form>
  </div>

</body>
<?php
$conexao->close();
?>

</html>

</html>