<?php

require("config.php");

// Consulta ao banco de dados
$id_turma = $_GET['fk_ID_turma'];
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

$result = $conn->query($sql);

// Cria um arquivo CSV
$csvFileName = 'relatorioFaltas.csv';
$csvFile = fopen($csvFileName, 'w');

// Escreve os cabeçalhos no arquivo CSV
$cabecalhos = ['Número do Atirador', 'Nome do Atirador', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Total de Faltas'];
fputcsv($csvFile, $cabecalhos);

// Escreve os dados no arquivo CSV
foreach($result as $row){
    $data = [
        $row['Numero_ATDR'],
        $row['NomeG'],
        $row['Março'],
        $row['Abril'],
        $row['Maio'],
        $row['Junho'],
        $row['Julho'],
        $row['Agosto'],
        $row['Setembro'],
        $row['Outubro'],
        $row['Novembro'],
        $row['TotalFaltas'],
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
