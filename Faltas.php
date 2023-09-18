<?php
require("config.php");
$id_turma = $_GET['fk_ID_turma']; //pega o id da URL para mostrar o usuário de acordo com a turma
$sql_turma = "select * from tb_turma where ID_turma = :id";
$consulta_turma = $conn->prepare($sql_turma);
$consulta_turma->bindParam(":id", $id_turma);
$consulta_turma->execute();
$resultado_turma = $consulta_turma->fetch(PDO::FETCH_OBJ);
$conn = mysqli_connect('localhost', 'root', '', 'tg_05-012');

// Verifica a conexão
if ($conn->connect_error) {
   die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if (isset($_GET['mensagem'])){
  $mensagem = $_GET['mensagem'];
  }

if ($consulta_turma->rowCount() >= 1) {
// Consulta para calcular o total de faltas por mês para cada atirador
if (isset($_GET['Buscar'])) {
$nome = $_GET['Busca'];
$sql = "SELECT Numero_ATDR, NomeG, ID_ATDR, 
SUM(CASE WHEN MesFalta = 'Março' THEN TotalF ELSE 0 END) AS Março,
SUM(CASE WHEN MesFalta = 'Abril' THEN TotalF ELSE 0 END) AS Abril,
SUM(CASE WHEN MesFalta = 'Maio' THEN TotalF ELSE 0 END) AS Maio,
SUM(CASE WHEN MesFalta = 'Junho' THEN TotalF ELSE 0 END) AS Junho,
SUM(CASE WHEN MesFalta = 'Julho' THEN TotalF ELSE 0 END) AS Julho,
SUM(CASE WHEN MesFalta = 'Agosto' THEN TotalF ELSE 0 END) AS Agosto,
SUM(CASE WHEN MesFalta = 'Setembro' THEN TotalF ELSE 0 END) AS Setembro,
SUM(CASE WHEN MesFalta = 'Outubro' THEN TotalF ELSE 0 END) AS Outubro,
SUM(CASE WHEN MesFalta = 'Novembro' THEN TotalF ELSE 0 END) AS Novembro,
SUM(TotalF) AS TotalFaltas
FROM (
    SELECT Numero_ATDR, ID_ATDR, NomeG, MesFalta, SUM(TotalF) AS TotalF
    FROM tb_atiradores
    LEFT JOIN tb_faltas ON tb_atiradores.ID_ATDR = tb_faltas.fk_ID_ATDR
    WHERE tb_atiradores.fk_ID_turma = $id_turma and (NomeG like '$nome%' or Numero_ATDR = '$nome') 
    GROUP BY Numero_ATDR, NomeG, MesFalta
)  AS subquery
GROUP BY Numero_ATDR, NomeG";


 }else{
  $sql = "SELECT Numero_ATDR, NomeG, ID_ATDR, 
  SUM(CASE WHEN MesFalta = 'Março' THEN TotalF ELSE 0 END) AS Março,
  SUM(CASE WHEN MesFalta = 'Abril' THEN TotalF ELSE 0 END) AS Abril,
  SUM(CASE WHEN MesFalta = 'Maio' THEN TotalF ELSE 0 END) AS Maio,
  SUM(CASE WHEN MesFalta = 'Junho' THEN TotalF ELSE 0 END) AS Junho,
  SUM(CASE WHEN MesFalta = 'Julho' THEN TotalF ELSE 0 END) AS Julho,
  SUM(CASE WHEN MesFalta = 'Agosto' THEN TotalF ELSE 0 END) AS Agosto,
  SUM(CASE WHEN MesFalta = 'Setembro' THEN TotalF ELSE 0 END) AS Setembro,
  SUM(CASE WHEN MesFalta = 'Outubro' THEN TotalF ELSE 0 END) AS Outubro,
  SUM(CASE WHEN MesFalta = 'Novembro' THEN TotalF ELSE 0 END) AS Novembro,
  SUM(TotalF) AS TotalFaltas
  FROM (
      SELECT Numero_ATDR, ID_ATDR, NomeG, MesFalta, SUM(TotalF) AS TotalF
      FROM tb_atiradores
      LEFT JOIN tb_faltas ON tb_atiradores.ID_ATDR = tb_faltas.fk_ID_ATDR
      WHERE tb_atiradores.fk_ID_turma = $id_turma
      GROUP BY Numero_ATDR, NomeG, MesFalta
  )  AS subquery
  GROUP BY Numero_ATDR, NomeG";
 }
 
$result = $conn->query($sql);
} else {
  $mensagem = "NENHUM ATIRADOR ENCONTRADO!";
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faltas</title>
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

  <?php require_once("Nav.php"); ?>
  <br>
  <div class="container">
    <div class="card bg-dark text-light">
      <div class="card-body">
        <center>
          <h2 class="card-title">Atiradores da turma <?= $resultado_turma->AnoTurma ?></h2>
          <a href="ListarAtiradores.php?fk_ID_turma=<?= $id_turma ?>" class="btn btn-warning btn-sm">Voltar</a>
          <?php if ($result->num_rows > 0) {?>
          <a href="GerarExcellFaltas.php?fk_ID_turma=<?=$id_turma?>" class="btn btn-primary btn-sm">Gerar Excell <i class="fa-regular fa-file-excel"></i></a>
          <?php }?>
          <form method="get" align="right" id="meuForm">
              <input type="hidden" name="fk_ID_turma" value="<?=$id_turma?>">
              <input name="Busca" type="text" class="form-control-sm" id="meuInput" placeholder="Buscar Atirador">
              <button type="submit" class="btn btn-primary btn-sm" name="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </center>
      </div>
    </div>

    <?php if (isset($mensagem)) : ?>
      <div class="alert alert-success" role="alert">
        <?= $mensagem ?>
      </div>
    <?php endif; ?>

    
  <div class="table-responsive bg-dark">
  <?php 
  if ($result->num_rows > 0) {
        echo "<table class='table table-striped table-dark' style='text-align: center;'>";
        echo "<tr><th scope='col'>Número do Atirador</th><th scope='col'>Nome do Atirador</th><th scope='col'>Março</th><th scope='col'>Abril</th><th scope='col'>Maio</th><th scope='col'>Junho</th><th scope='col'>Julho</th><th scope='col'>Agosto</th><th scope='col'>Setembro</th><th scope='col'>Outubro</th><th scope='col'>Novembro</th><th scope='col'>Total de Faltas</th><th scope='col'>Pontos restantes</th><th scope='col'>Operações</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["Numero_ATDR"]."</td><td>".$row["NomeG"]."</td><td>".$row["Março"]."</td><td>".$row["Abril"]."</td><td>".$row["Maio"]."</td><td>".$row["Junho"]."</td><td>".$row["Julho"]."</td><td>".$row["Agosto"]."</td><td>".$row["Setembro"]."</td><td>".$row["Outubro"]."</td><td>".$row["Novembro"]."</td><td>".$row["TotalFaltas"]."</td><td>". 120 - $row["TotalFaltas"]."</td><td><a href='InfoFaltas.php?fk_ID_turma=".$id_turma."&id=".$row["ID_ATDR"]."'><i class='fa-solid fa-circle-info'></i></a> <a href='AdFaltas.php?fk_ID_turma=".$id_turma."&id=".$row["ID_ATDR"]."'><i class='fa-solid fa-square-plus'></i></a></td></tr>";
        }

        echo "</table>";
    } else {
        echo "Nenhum resultado encontrado.";
    }

  ?>
  </div>
  </div>

  <?php
  $conn->close();
  ?>
</body>

</html>