<?php
if (isset($_GET['file'])) {
    $filename = $_GET['file'];
    $filepath = $filename;

    // Verifica se o arquivo existe
    if (file_exists($filepath)) {
        // Define os headers para o download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        echo "O arquivo não existe.";
    }
}
?>
