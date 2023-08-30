<?php

// Faz a Conexão com o bando de dados do TG.

$conexao = mysqli_connect('localhost', 'root', 'root', 'tg_05-012');


$id_turma = $_GET['ID_turma']; //pega o id da URL para mostrar o usuário de acordo com a turma
$sql = "select * from atiradores where ID_turma = {$id_turma}";
$resultado = mysqli_query($conexao, $sql);

//verifica o ano da turma de acordo com o ID da turma
$PegarAno = "select * from turma where ID = {$id_turma}";
$ano = mysqli_query($conexao, $PegarAno);
$row2 = mysqli_fetch_array($ano);

//verifica se a turma possui registros nela
if (mysqli_num_rows($resultado) >= 1) {
  $linha = mysqli_fetch_array($resultado);

//Executa o camando de deletar atiradores
  if (isset($_GET['id'])) :
    $sql = "delete from atiradores where ID_ATDRS = {$_GET['id']}";
    mysqli_query($conexao, $sql);
    $mensagem = "Registro excluído com sucesso.";
  endif;


  //Reconhece os atiradores desligados
  if (!(isset($_GET['Desligados']))) {
    $sql = "select * from atiradores where ID_turma = '$id_turma' order by NomeC asc";
    $resultado = mysqli_query($conexao, $sql);

    //executar a SQL
    mysqli_query($conexao, $sql);
  }

  if (isset($_GET['Desligados'])) {
    $sql = "select * from atiradores where ID_turma = '$id_turma' and Situacao = 'Desligado' order by NomeC asc";
    $resultado = mysqli_query($conexao, $sql);

    //executa a SQL
    mysqli_query($conexao, $sql);
  }

  //Organiza os atiradores por ordem alfabética
  if (isset($_GET['AlfaCresc'])) {
    $sql = "select * from atiradores where ID_turma = '$id_turma' order by NomeC asc";
    $resultado = mysqli_query($conexao, $sql);

    //executar a SQL
    mysqli_query($conexao, $sql);
  }

  if (isset($_GET['AlfaDesc'])) {
    $sql = "select * from atiradores where ID_turma = '$id_turma' order by NomeC desc";
    $resultado = mysqli_query($conexao, $sql);

    //executar a SQL
    mysqli_query($conexao, $sql);
  }

  //Busca os atiradores de acordo com o nome de guerra ou numero
  if (isset($_GET['Buscar'])) {
    $nome = $_GET['Busca'];
    $sql = "select * from atiradores where ID_turma = '$id_turma' and (NomeG like '$nome%' or Numero = '$nome') order by NomeC desc";
    $resultado = mysqli_query($conexao, $sql);

    //executar a SQL
    mysqli_query($conexao, $sql);
  }

  //parte responsável por numerar os atiradores de acordo com sua ordem alfabética

  //Recuperar os registros da tabela em ordem alfabética
  $sql2 = "SELECT ID_ATDRS, NomeC FROM atiradores where ID_turma = '$id_turma' ORDER BY NomeC ASC";
  $resultado2 = mysqli_query($conexao, $sql2);

  // Inicializar o contador
  $contador = 1;

  // Atualizar a tabela com os números atribuídos em ordem alfabética
  while ($row = mysqli_fetch_assoc($resultado2)) {
    $id = $row["ID_ATDRS"];
    $numero_alfabetico = $contador;

    // Atualizar o registro com o número atribuído
    $sql_update = "UPDATE atiradores SET Numero = $numero_alfabetico WHERE ID_ATDRS = $id";
    mysqli_query($conexao, $sql_update);

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

  <br>

  <div class="container">
    <div class="card bg-dark text-light">
      <div class="card-body">
        <center>
          <h2 class="card-title">Atiradores da turma <?= $row2['Ano']?></h2>
          <a href="ListarAtiradores.php?ID_turma=<?= $linha['ID_turma'] ?>" class="btn btn-primary btn-sm">Atualizar</a>
          <a href="Faltas.php?ID_turma=<?= $linha['ID_turma'] ?>" class="btn btn-primary btn-sm">Faltas</a>
          <br><br>
          <?php if (mysqli_num_rows($resultado) >= 1) { ?>
            <form method="get" align="right" id="meuForm">
              <input type="hidden" name="ID_turma" value="<?= $linha['ID_turma'] ?>">
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

    <?php if (isset($mensagem)) : ?>
      <div class="alert alert-success" role="alert">
        <?= $mensagem ?>
      </div>
    <?php endif; ?>

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
          <?php while ($linha = mysqli_fetch_array($resultado)) : ?>
            <tr>
              <td><?= $linha['Numero'] ?></td>
              <td>
                <?php
                if ($linha['Imagem']) :
                  $Imagem = $linha['Imagem'];
                ?>
                  <a href="<?php echo $Imagem ?>" target="_blank">
                    <img src="<?php echo $Imagem ?>" width="100" height="150">
                  </a>
                <?php
                endif;
                ?>
              </td>
              <td><?= $linha['Situacao'] ?></td>
              <td><?= $linha['NRa'] ?></td>
              <td><?= $linha['NomeC'] ?></td>
              <td><?= $linha['NomeG'] ?></td>
              <td><?= $linha['NomePai'] ?></td>
              <td><?= $linha['TelPai'] ?></td>
              <td><?= $linha['NomeMae'] ?></td>
              <td><?= $linha['TelMae'] ?></td>
              <td><?= $linha['DataNasc'] ?></td>
              <td><?= $linha['LocalNasc'] ?></td>
              <td><?= $linha['CPF'] ?></td>
              <td><?= $linha['RG'] ?></td>
              <td><?= $linha['Religiao'] ?></td>
              <td><?= $linha['Escolaridade'] ?></td>
              <td><?= $linha['NTituloEleitor'] ?></td>
              <td><?= $linha['TipoSangue'] ?></td>
              <td><?= $linha['Habilitacao'] ?></td>
              <td><?= $linha['TelContato'] ?></td>
              <td>
                <div class="scrollable-cell"><?= $linha['Endereco'] ?></div>
              </td>
              <td><?= $linha['Profissao'] ?></td>
              <td><?= $linha['HProfissao'] ?></td>
              <td><?= $linha['CarteiraAss'] ?></td>
              <td><?= $linha['RemuneracaoM'] ?></td>
              <td><?= $linha['RendaF'] ?></td>
              <td>
                <a href="AlterarAtiradores.php?id=<?= $linha['ID_ATDRS'] ?>">
                  <button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                </a>
                <a href="ListarAtiradores.php?ID_turma=<?= $linha['ID_turma'] ?>&id=<?= $linha['ID_ATDRS'] ?>" onclick="return confirm('Confirma exclusão?')">
                  <button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-trash-can"></i></button>
                </a>
              </td>
              <td>
                <br>
                <a href="AlterarImagem.php?id=<?= $linha['ID_ATDRS'] ?>">
                  <button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-image"></i></button>
                </a>
              </td>
            </tr>
    </div>
  <?php endwhile; ?>
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

</html>