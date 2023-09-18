<?php
require("config.php");
$conexao = mysqli_connect('localhost', 'root', '', 'tg_05-012');
$id = $_GET['id']; //pega o id da URL para mostrar o usuário
$id_turma = $_GET['fk_ID_turma']; //pega o id da URL para mostrar o usuário
if (isset($_POST['salvar'])) {

    $id = $_POST['id'];
    $NRa = $_POST['NRa'];
    $NomeC = $_POST['NomeC'];
    $NomeG = $_POST['NomeG'];
    $NomePai = $_POST['NomePai'];
    $TelPai = $_POST['TelPai'];
    $NomeMae = $_POST['NomeMae'];
    $TelMae = $_POST['TelMae'];
    $DataNasc = $_POST['DataNasc'];
    $LocalNasc = $_POST['LocalNasc'];
    $CPF = $_POST['CPF'];
    $RG = $_POST['RG'];
    $Religiao = $_POST['Religiao'];
    $Escolaridade = $_POST['Escolaridade'];
    $NTitulo = $_POST['NTitulo'];
    $TipoS = $_POST['TipoS'];
    $Habilitacao = $_POST['Habilitacao'];
    $TelContato = $_POST['TelContato'];
    $Endereco = $_POST['Endereco'];
    $Profissao = $_POST['Profissao'];
    $HProfissao = $_POST['HProfissao'];
    $CarteiraAss = $_POST['CarteiraAss'];
    $RemuM = $_POST['RemuM'];
    $RendaF = $_POST['RendaF'];
    $Situacao = $_POST['Situacao'];

    $sql = "update tb_atiradores set NRa = '{$NRa}',
                NomeC = '{$NomeC}',
                NomeG = '{$NomeG}',
                NomePai = '{$NomePai}',
                TelPai = '{$TelPai}',
                NomeMae = '{$NomeMae}',
                TelMae = '{$TelMae}',
                DataNasc = '{$DataNasc}',
                LocalNasc = '{$LocalNasc}',
                CPF = '{$CPF}',
                RG = '{$RG}',
                Religiao = '{$Religiao}',
                Escolaridade = '{$Escolaridade}',
                NTituloEleitor = '{$NTitulo}',
                TipoSangue = '{$TipoS}', 
                Habilitacao = '{$Habilitacao}',
                TelContato = '{$TelContato}',
                Endereco = '{$Endereco}',
                Profissao = '{$Profissao}',
                HProfissao = '{$HProfissao}', 
                CarteiraAss = '{$CarteiraAss}', 
                RemuneracaoM = '{$RemuM}',
                RendaF = '{$RendaF}',
                Situacao = '{$Situacao}' where ID_ATDR = '{$id}'";


    $consulta = mysqli_query($conexao, $sql);

    header("Location: ListarAtiradores.php?mensagem=Atirador alterado com sucesso!&fk_ID_turma=$id_turma");
}

$sql = "select * from tb_atiradores where ID_ATDR = :id";
$consulta = $conn->prepare($sql);
$consulta->bindParam(":id", $_GET['id']);
$consulta->execute();
$linha = $consulta->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Alterar Atirador</title>
    <link rel="icon" href="EB.png">

    <style>

        body {

            background-repeat: repeat;
            overflow-x: hidden;
        }

     

  </style>
</head>

<body background="camuflado.png">

    <?php
    require_once('Nav.php')
    ?>

    <div class="container">
        <?php if (isset($mensagem)) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensagem ?>
            </div>
        <?php } ?>
    </div>
<br><br>

    <div class="container">
        <form method="post" class="row g-3 bg-dark shadow-none p-3 mb-5 text-light rounded" enctype="multipart/form-data">
        <center>
            <h1>Alterar Usuario</h1>
        </center>
        <br>
            <input type="hidden" name="id" value="<?= $linha['ID_ATDR'] ?>">
            <div class="col-md-3">
                <label for="NRa" class="form-label">N° do RA</label>
                <input name="NRa" type="text" class="form-control" id="NRa" required value="<?= $linha['NRa'] ?>">
            </div>
            <div class="col-md-3">
                <label for="NomeC" class="form-label">Nome Completo</label>
                <input name="NomeC" type="text" class="form-control" id="NomeC" required value="<?= $linha['NomeC'] ?>">
            </div>
            <div class="col-md-3">
                <label for="NomeG" class="form-label">Nome de Guerra</label>
                <input name="NomeG" type="text" class="form-control" id="NomeG" required value="<?= $linha['NomeG'] ?>">
            </div>
            <div class="col-md-3">
                <label for="NomePai" class="form-label">Nome do Pai</label>
                <input name="NomePai" type="text" class="form-control" id="NomePai" required value="<?= $linha['NomePai'] ?>">
            </div>
            <div class="col-md-3">
                <label for="TelPai" class="form-label">Telefone Do Pai</label>
                <input name="TelPai" type="text" class="form-control" id="TelPai" required value="<?= $linha['TelPai'] ?>">
            </div>
            <div class="col-md-3">
                <label for="NomeMae" class="form-label">Nome da Mãe</label>
                <input name="NomeMae" type="text" class="form-control" id="NomMae" required value="<?= $linha['NomeMae'] ?>">
            </div>
            <div class="col-md-3">
                <label for="TelMae" class="form-label">Telefone Da Mãe</label>
                <input name="TelMae" type="text" class="form-control" id="TelMae" required value="<?= $linha['TelMae'] ?>">
            </div>
            <div class="col-md-3">
                <label for="DataNasc" class="form-label">Data de Nascimento</label>
                <input name="DataNasc" type="date" class="form-control" id="DataNasc" required value="<?= $linha['DataNasc'] ?>">
            </div>
            <div class="col-md-3">
                <label for="LocalNasc" class="form-label">Local de Nascimento</label>
                <input name="LocalNasc" type="text" class="form-control" id="LocalNasc" required value="<?= $linha['LocalNasc'] ?>">
            </div>
            <div class="col-md-3">
                <label for="CPF" class="form-label">CPF</label>
                <input name="CPF" type="text" class="form-control" id="CPF" required value="<?= $linha['CPF'] ?>">
            </div>
            <div class="col-md-3">
                <label for="RG" class="form-label">N° do RG</label>
                <input name="RG" type="text" class="form-control" id="RG" required value="<?= $linha['RG'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Religiao" class="form-label">Religião</label>
                <input name="Religiao" type="text" class="form-control" id="Religiao" required value="<?= $linha['Religiao'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Escolaridade" class="form-label">Escolaridade</label>
                <input name="Escolaridade" type="text" class="form-control" id="Escolaridade" required value="<?= $linha['Escolaridade'] ?>">
            </div>
            <div class="col-md-3">
                <label for="NTitulo" class="form-label">N° do Titulo de Eleitor</label>
                <input name="NTitulo" type="text" class="form-control" id="NTitulo" required value="<?= $linha['NTituloEleitor'] ?>">
            </div>
            <div class="col-md-3">
                <label for="TipoS" class="form-label">Tipo Sanguíneo</label>
                <input name="TipoS" type="text" class="form-control" id="TipoS" required value="<?= $linha['TipoSangue'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Habilitacao" class="form-label">Habilitação</label>
                <input name="Habilitacao" type="text" class="form-control" id="Habilitacao" required value="<?= $linha['Habilitacao'] ?>">
            </div>
            <div class="col-md-3">
                <label for="TelContato" class="form-label">Telefone de Contato</label>
                <input name="TelContato" type="text" class="form-control" id="TelContato" required value="<?= $linha['TelContato'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Endereco" class="form-label">Endereço</label>
                <input name="Endereco" type="text" class="form-control" id="Endereco" required value="<?= $linha['Endereco'] ?>">
            </div>
            <div class="col-md-3">
                <label for="Profissao" class="form-label">Profissão</label>
                <input name="Profissao" type="text" class="form-control" id="Profissao" require value="<?= $linha['Profissao'] ?>">
            </div>
            <div class="col-md-3">
                <label for="HProfissao" class="form-label">Horário</label>
                <input name="HProfissao" type="text" class="form-control" id="HProfissao" required value="<?= $linha['HProfissao'] ?>">
            </div>
            <div class="col-md-3">
                Carteira Asssinada?
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="CarteiraAss" id="CarteiraAssSim" value="Sim" <?php
                                                                                                                    if ($linha['CarteiraAss'] == "Sim") {
                                                                                                                        echo 'checked';
                                                                                                                    }
                                                                                                                    ?>>
                    <label class="form-check-label" for="CarteiraAssSim">
                        Sim
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="CarteiraAss" id="CarteiraAssNao" value="Não" <?php
                                                                                                                    if ($linha['CarteiraAss'] == "Não") {
                                                                                                                        echo 'checked';
                                                                                                                    }
                                                                                                                    ?>>
                    <label class="form-check-label" for="CarteiraAssNao">
                        Não
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <label for="RemuM" class="form-label">Remuneração Mensal</label>
                <input name="RemuM" type="text" class="form-control" id="RemuM" required value="<?= $linha['RemuneracaoM'] ?>">
            </div>
            <div class="col-md-3">
                <label for="RendaF" class="form-label">Renda Familiar</label>
                <input name="RendaF" type="text" class="form-control" id="RendaF" required value="<?= $linha['RendaF'] ?>">
            </div>
            <div class="col-md-3">
                Situação
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="Situacao" id="SituacaoLiga" value="Ligado" <?php
                                                                                                                    if ($linha['Situacao'] == "Ligado") {
                                                                                                                        echo 'checked';
                                                                                                                    }
                                                                                                                    ?>>
                    <label class="form-check-label" for="SituacaoLiga">
                        Ligado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="Situacao" id="SituacaoDesli" value="Desligado" <?php
                                                                                                                        if ($linha['Situacao'] == "Desligado") {
                                                                                                                            echo 'checked';
                                                                                                                        }
                                                                                                                        ?>>
                    <label class="form-check-label" for="SituacaoDesli">
                        Desligado
                    </label>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" name="salvar"> Salvar </button>
                <a class="btn btn-warning" href="ListarAtiradores.php?fk_ID_turma=<?=$id_turma?>">Voltar</a>
            </div>

        </form>
    </div>



</body>
<?php
$conexao->close();
?>
</html>