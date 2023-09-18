<?php
require("config.php");

if (isset($_GET['id_falta'])) {
    $sql_delete_atdr = "delete from tb_faltas where ID_Falta = :id";
    $consulta_delete_atdr = $conn->prepare($sql_delete_atdr);
    $consulta_delete_atdr->bindParam(":id", $_GET["id_falta"]);
    $consulta_delete_atdr->execute();
    $resultado_delete_atdr = $consulta_delete_atdr->fetchAll(PDO::FETCH_OBJ);
}
$id_turma = $_GET['fk_ID_turma']; //pega o id da URL para mostrar o usuário
$id = $_GET['id']; //pega o id da URL para mostrar o usuário de acordo com a turma
$sql_atdrs = "select * from tb_faltas where fk_ID_ATDR = :id";
$consulta_atdrs = $conn->prepare($sql_atdrs);
$consulta_atdrs->bindParam(":id", $id);
$consulta_atdrs->execute();
$resultado_atdrs = $consulta_atdrs->fetchAll(PDO::FETCH_OBJ);
if (($consulta_atdrs->rowCount() < 1)) {
    $mensagem = "Nenhuma falta encontrada!";
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
    <?php if (isset($mensagem)) : ?>
        <div class="alert alert-success" role="alert">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>
    <br>
    <div class="container">
        <div class="card bg-dark text-light">
            <div class="card-body">
                <center>
                    <h2 class="card-title">Lista de faltas</h2>
                    <a href="Faltas.php?fk_ID_turma=<?= $id_turma ?>" class="btn btn-warning btn-sm">Voltar</a>
                </center>
            </div>
        </div>
        <div class="table-responsive bg-dark">
            <table class="table table-striped table-dark" style="text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">Dia da falta</th>
                        <th scope="col">Mês</th>
                        <th scope="col">Justificativa</th>
                        <th scope="col">Pontos perdidos</th>
                        <th scope="col">Atestado/Arquivo</th>
                        <th scope="col">Deletar falta</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($resultado_atdrs as $linha) {
                    ?>
                        <tr>
                            <td><?= $linha->DiaFalta ?></td>
                            <td><?= $linha->MesFalta ?></td>
                            <td><?= $linha->JustificativaF ?></td>
                            <td><?= $linha->PontoFaltas ?></td>
                            <?php if (($linha->ArquivoC) != "Upload/") { ?>
                                <td><a href="download.php?file=<?= $linha->ArquivoC ?>" class="btn btn-primary btn-sm">Baixar Arquivo</a>
                                </td>
                            <?php } else { ?>
                                <td>Nada</td>
                            <?php } ?>
                            <td><a href="InfoFaltas.php?id=<?= $linha->fk_ID_ATDR ?>&id_falta=<?= $linha->ID_Falta ?>&fk_ID_turma=<?=$id_turma?>&mensagem=Falta excluída com sucesso." onclick="return confirm('Confirma exclusão?')">
                                    <button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                                </a></td>
                        </tr>
        </div>
    <?php
                    } ?>
    </tbody>
    </table>
    </div>

    </div>

</body>

</html>