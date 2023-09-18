<?php
require("config.php");
// Faz a Conexão com o bando de dados do TG.

$conexao = mysqli_connect('localhost', 'root', '', 'tg_05-012');

$id_turma = $_GET['fk_ID_turma']; //pega o id da URL para mostrar o usuário de acordo com a turma
$sql = "select * from tb_atiradores where fk_ID_turma = :id";
$consulta = $conn->prepare($sql);
$consulta->bindParam(":id", $id_turma);
$consulta->execute();
$resultado = $consulta->fetchAll(PDO::FETCH_OBJ);

//verifica o ano da turma de acordo com o ID da turma
$sql_turma = "select * from tb_turma where ID_Turma = :id";
$consulta_turma = $conn->prepare($sql_turma);
$consulta_turma->bindParam(":id", $id_turma);
$consulta_turma->execute();
$resultado_turma = $consulta_turma->fetch(PDO::FETCH_OBJ);

//verifica se a turma possui registros nela

if ($consulta->rowCount() >= 1) {

  $linha = $consulta_turma->rowCount();

//Executa o camando de deletar atiradores
  if (isset($_GET['id'])) {
    $sql_delete_Faltas = "delete from tb_faltas where fk_ID_ATDR = :id";
    $consulta_delete_Faltas = $conn->prepare($sql_delete_Faltas);
    $consulta_delete_Faltas->bindParam(":id", $_GET["id"]);
    $consulta_delete_Faltas->execute();
    $resultado_delete_Faltas = $consulta_delete_Faltas->fetchAll(PDO::FETCH_OBJ);
    $sql_delete_atdr = "delete from tb_atiradores where ID_ATDR = :id";
    $consulta_delete_atdr = $conn->prepare($sql_delete_atdr);
    $consulta_delete_atdr->bindParam(":id", $_GET["id"]);
    $consulta_delete_atdr->execute();
    $resultado_delete_atdr = $consulta_delete_atdr->fetchAll(PDO::FETCH_OBJ);
    $mensagem = "Registro excluído com sucesso.";
}


  //Reconhece os atiradores desligados
  if (!(isset($_GET['Desligados']))) {
    $sql_atdrs = "select * from tb_atiradores where fk_ID_turma = :id order by NomeC asc";
    $consulta_atdrs = $conn->prepare($sql_atdrs);
    $consulta_atdrs->bindParam(":id", $id_turma);
    $consulta_atdrs->execute();
    $resultado_atdrs = $consulta_atdrs->fetchAll(PDO::FETCH_OBJ);
  }

  if (isset($_GET['Desligados'])) {
    $sql_atdrs = "select * from tb_atiradores where fk_ID_turma = :id and Situacao = 'Desligado' order by NomeC asc";
    $consulta_atdrs = $conn->prepare($sql_atdrs);
    $consulta_atdrs->bindParam(":id", $id_turma);
    $consulta_atdrs->execute();
    $resultado_atdrs = $consulta_atdrs->fetchAll(PDO::FETCH_OBJ);
  }

  //Organiza os atiradores por ordem alfabética
  if (isset($_GET['AlfaCresc'])) {
    $sql_atdrs = "select * from tb_atiradores where fk_ID_turma = :id order by NomeC asc";
    $consulta_atdrs = $conn->prepare($sql_atdrs);
    $consulta_atdrs->bindParam(":id", $id_turma);
    $consulta_atdrs->execute();
    $resultado_atdrs = $consulta_atdrs->fetchAll(PDO::FETCH_OBJ);
  }

  if (isset($_GET['AlfaDesc'])) {
    $sql_atdrs = "select * from tb_atiradores where fk_ID_turma = :id order by NomeC desc";
    $consulta_atdrs = $conn->prepare($sql_atdrs);
    $consulta_atdrs->bindParam(":id", $id_turma);
    $consulta_atdrs->execute();
    $resultado_atdrs = $consulta_atdrs->fetchAll(PDO::FETCH_OBJ);
  }

  //Busca os atiradores de acordo com o nome de guerra ou numero
  if (isset($_GET['Buscar'])) {
    $nome = $_GET['Busca'];
    $sql_atdrs = "select * from tb_atiradores where fk_ID_turma = :id and (NomeG like '$nome%' or Numero_ATDR = '$nome') order by NomeC desc";
    $consulta_atdrs = $conn->prepare($sql_atdrs);
    $consulta_atdrs->bindParam(":id", $id_turma);
    $consulta_atdrs->execute();
    $resultado_atdrs = $consulta_atdrs->fetchAll(PDO::FETCH_OBJ);
  }

  //parte responsável por numerar os atiradores de acordo com sua ordem alfabética

  //Recuperar os registros da tabela em ordem alfabética
  $sql_ordemA = "SELECT ID_ATDR, NomeC FROM tb_atiradores where fk_ID_turma = id: ORDER BY NomeC ASC";
  $consulta_ordemA = $conn->prepare($sql_ordemA);

  // Inicializar o contador
  $contador = 1;

  // Atualizar a tabela com os números atribuídos em ordem alfabética
  foreach ($resultado_atdrs as $row){
    $id = $row->ID_ATDR;
    $numero_alfabetico = $contador;

    // Atualizar o registro com o número atribuído
    $sql_update = "UPDATE tb_atiradores SET Numero_ATDR = $numero_alfabetico WHERE ID_ATDR = $id";
    mysqli_query($conexao, $sql_update);
    $consulta_update = $conn->prepare($sql_update);

    $contador++;
  }

} else {
  $mensagem = "NENHUM ATIRADOR ENCONTRADO!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar Atiradores</title>
  <link rel="icon" href="EB.png">
  <script src="https://kit.fontawesome.com/309120fd85.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

  <style>
    /* Parte responsável por redimencionar a lista*/
    /* Estilos personalizados para a célula com scroll */
    .scrollable-cell {
      max-height: 150px;
      /* Ajuste esta altura conforme necessário */
      overflow-y: auto;
    }

    .table-responsive {
      font-size: 14px;
    }

  </style>

</head>

<body background="camuflado.png">

  <?php
  require_once('Nav.php');
  ?>
    <?php if (isset($mensagem)) : ?>
      <div class="alert alert-success" role="alert">
        <?= $mensagem?>
      </div>
    <?php endif; ?>

  <br>
  <div class="container">
    <div class="card bg-dark text-light">
      <div class="card-body">
        <center>
          <h2 class="card-title">Atiradores da turma <?=$resultado_turma->AnoTurma?></h2>
          <a href="ListarAtiradores.php?fk_ID_turma=<?= $id_turma ?>" class="btn btn-primary btn-sm">Atualizar</a>
          <?php if ($consulta->rowCount() >= 1) { ?>
          <a href="Faltas.php?fk_ID_turma=<?= $id_turma?>" class="btn btn-primary btn-sm">Faltas</a>
          <a href="GerarExcell.php?fk_ID_turma=<?=$id_turma?>" class="btn btn-primary btn-sm">Gerar Excell <i class="fa-regular fa-file-excel"></i></a>
          <br><br>
            <form method="get" align="right" id="meuForm">
              <input type="hidden" name="fk_ID_turma" value="<?=$id_turma?>">
              <button type="submit" class="btn btn-warning btn-sm" name="Desligados"><i class="fa-solid fa-power-off"></i></button>
              <button type="submit" class="btn btn-warning btn-sm" name="AlfaCresc"><i class="fa-solid fa-arrow-down-z-a"></i></button>
              <button type="submit" class="btn btn-warning btn-sm" name="AlfaDesc"><i class="fa-solid fa-arrow-up-z-a"></i></button>
              <input name="Busca" type="text" class="form-control-sm" id="meuInput" placeholder="Buscar Atirador">
              <button type="submit" class="btn btn-primary btn-sm" name="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
          <?php } ?>
        </center>
      </div>
    </div>

    <div class="table-responsive bg-dark">
      <table class="table table-striped table-dark" style="text-align: center;">
        <thead>
          <tr>
            <th scope="col">N° Atdr</th>
            <th scope="col">Foto</th>
            <th scope="col">Ligado/Desligado</th>
            <th scope="col">N° do RA</th>
            <th scope="col">Nome Completo</th>
            <th scope="col">Nome de Guerra</th>
            <th scope="col">Nome do Pai</th>
            <th scope="col">Telefone Pai</th>
            <th scope="col">Nome da Mãe</th>
            <th scope="col">Telefone Mãe</th>
            <th scope="col">Data De Nascimento</th>
            <th scope="col">Local de Nascimento</th>
            <th scope="col">CPF</th>
            <th scope="col">N° RG</th>
            <th scope="col">Religião</th>
            <th scope="col">Escolaridade</th>
            <th scope="col">N° Titulo Eleitor</th>
            <th scope="col">Tipo Sanguíneo</th>
            <th scope="col">Habilitação</th>
            <th scope="col">Telefone de Contato</th>
            <th scope="col">Endereço</th>
            <th scope="col">Profissão</th>
            <th scope="col">Horário</th>
            <th scope="col">Carteira Assinada</th>
            <th scope="col">Remuneração Mensal</th>
            <th scope="col">Renda Familiar</th>
            <th scope="col">Alterar dados</th>
            <th scope="col">Alterar Imagem</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultado_atdrs as $linha ) { 
            ?>
            <tr>
              <td><?= $linha->Numero_ATDR ?></td>
              <td>
                <?php
                if ($linha->Imagem) :
                  $Imagem = $linha->Imagem;
                ?>
                  <a href="<?php echo $Imagem ?>" target="_blank">
                    <img src="<?php echo $Imagem ?>" width="100" height="150">
                  </a>
                <?php
                endif;
                ?>
              </td>
              <td><?= $linha->Situacao ?></td>
              <td><?= $linha->NRa?></td>
              <td><?= $linha->NomeC?></td>
              <td><?= $linha->NomeG ?></td>
              <td><?= $linha->NomePai ?></td>
              <td><?= $linha->TelPai ?></td>
              <td><?= $linha->NomeMae ?></td>
              <td><?= $linha->TelMae ?></td>
              <td><?= $linha->DataNasc ?></td>
              <td><?= $linha->LocalNasc ?></td>
              <td><?= $linha->CPF ?></td>
              <td><?= $linha->RG ?></td>
              <td><?= $linha->Religiao ?></td>
              <td><?= $linha->Escolaridade ?></td>
              <td><?= $linha->NTituloEleitor ?></td>
              <td><?= $linha->TipoSangue ?></td>
              <td><?= $linha->Habilitacao ?></td>
              <td><?= $linha->TelContato ?></td>
              <td>
                <div class="scrollable-cell"><?= $linha->Endereco?></div>
              </td>
              <td><?= $linha->Profissao ?></td>
              <td><?= $linha->HProfissao ?></td>
              <td><?= $linha->CarteiraAss ?></td>
              <td><?= $linha->RemuneracaoM ?></td>
              <td><?= $linha->RendaF ?></td>
              <td>
                <a href="AlterarAtiradores.php?id=<?= $linha->ID_ATDR?>&fk_ID_turma=<?=$id_turma?>">
                  <button type="button" class="btn btn-outline-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                </a>
                <a href="ListarAtiradores.php?fk_ID_turma=<?= $linha->fk_ID_turma ?>&id=<?= $linha->ID_ATDR ?>" onclick="return confirm('Confirma exclusão?')">
                  <button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                </a>
              </td>
              <td>
                <br>
                <a href="AlterarImagem.php?id=<?= $linha->ID_ATDR?>&fk_ID_turma=<?=$id_turma?>">
                  <button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-image"></i></button>
                </a>
              </td>
            </tr>
    </div>
  <?php }?>
  </tbody>
  </table>
  </div>

  <!--Impede que a tecla enter envia o formulário-->

  <script>
    // Captura o formulário
    const form = document.getElementById("meuForm");

    // Captura o input
    const input = document.getElementById("meuInput");

    // Adiciona um evento de tecla pressionada ao input
    input.addEventListener("keydown", function(event) {
      // Verifica se a tecla pressionada é o "Enter" (código 13)
      if (event.keyCode === 13) {
        // Impede o envio do formulário
        event.preventDefault();
      }
    });
  </script>


</body>
<?php
$conexao->close();
?>
</html>