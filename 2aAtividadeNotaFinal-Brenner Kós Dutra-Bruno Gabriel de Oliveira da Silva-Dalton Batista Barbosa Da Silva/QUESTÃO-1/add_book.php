<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'], $_POST['autor'], $_POST['ano_publicacao'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano_publicacao = $_POST['ano_publicacao'];

    $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, ano_publicacao) VALUES (?, ?, ?)");
    $stmt->execute([$titulo, $autor, $ano_publicacao]);

    header("Location: index.php");
    exit();
}