<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $dia = str_pad($_POST['dia'], 2, '0', STR_PAD_LEFT);
    $mes = str_pad($_POST['mes'], 2, '0', STR_PAD_LEFT);
    $ano = $_POST['ano'];

    $data_vencimento = "{$ano}-{$mes}-{$dia}";

    $sql = "INSERT INTO tarefas (descricao, data_vencimento, concluida) VALUES ('$descricao', '$data_vencimento', 0)";
    $conn->exec($sql);

    header('Location: index.php');
}
?>
