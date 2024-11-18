<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $stmt = $pdo->prepare("DELETE FROM livros WHERE id = ?");
    $stmt->execute([$id]);

    $count = $pdo->query("SELECT COUNT(*) FROM livros")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("DELETE FROM sqlite_sequence WHERE name='livros'");
    }

    header("Location: index.php");
    exit();
}