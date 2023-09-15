<?php

require("config.php");

// Consulta ao banco de dados
$id_turma = $_GET['ID_turma'];
$query = "SELECT * FROM atiradores where ID_turma = $id_turma order by Numero";
$consulta = $conn->prepare($query);
$consulta->execute();
$resultado = $consulta->fetchAll(PDO::FETCH_OBJ);

// Cria um arquivo CSV
$csvFileName = 'relatorio.csv';
$csvFile = fopen($csvFileName, 'w');

// Escreve os cabeçalhos no arquivo CSV
$cabecalhos = ['Numero', 'Situacao', 'Numero Ra', 'Nome Completo', 'Nome de Guerra', 'Nome do Pai', 'Telefone do Pai', 'Nome da mãe', 'Telefone da Mãe', 'Data de nascimento', 'Local de nascimento', 'CPF', 'RG', 'Religiao', 'Escolaridade', 'Nº Titulo Eleitoral', 'Tipo sanguinio', 'Habilitação', 'Telefone de contato', 'Endereço', 'Profissão', 'Horario', 'Carteira Assinada', 'Remuneração mensal', 'Renda Familiar'];

fputcsv($csvFile, $cabecalhos);

// Escreve os dados no arquivo CSV
foreach($resultado as $linha){
    $data = [
        $linha->Numero,
        $linha->Situacao,
        $linha->NRa,
        $linha->NomeC,
        $linha->NomeG,
        $linha->NomePai,
        $linha->TelPai,
        $linha->NomeMae,
        $linha->TelMae,
        $linha->DataNasc,
        $linha->LocalNasc,
        $linha->CPF,
        $linha->RG,
        $linha->Religiao,
        $linha->Escolaridade,
        $linha->NTituloEleitor,
        $linha->TipoSangue,
        $linha->Habilitacao,
        $linha->TelContato,
        $linha->Endereco,
        $linha->Profissao,
        $linha->HProfissao,
        $linha->CarteiraAss,
        $linha->RemuneracaoM,
        $linha->RendaF
    ];
    fputcsv($csvFile, $data);
}

// Fecha o arquivo CSV
fclose($csvFile);

// Define os cabeçalhos para download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $csvFileName . '"');

// Saída do arquivo CSV para o navegador
readfile($csvFileName);

// Deleta o arquivo CSV gerado
unlink($csvFileName);

// Fecha a conexão ao banco de dados

?>
