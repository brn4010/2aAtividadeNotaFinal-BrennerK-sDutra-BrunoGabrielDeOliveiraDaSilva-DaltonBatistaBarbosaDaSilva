<?php
$conn = new SQLite3('tarefas.db');

$conn->exec("CREATE TABLE IF NOT EXISTS tarefas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    descricao TEXT NOT NULL,
    data_vencimento DATE NOT NULL,
    concluida INTEGER DEFAULT 0
)");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descricao'], $_POST['data_vencimento'])) {
    $stmt = $conn->prepare("INSERT INTO tarefas (descricao, data_vencimento) VALUES (:descricao, :data_vencimento)");
    $stmt->bindValue(':descricao', $_POST['descricao'], SQLITE3_TEXT);
    $stmt->bindValue(':data_vencimento', $_POST['data_vencimento'], SQLITE3_TEXT);
    $stmt->execute();
    header('Location: index.php');
    exit();
}

if (isset($_GET['concluir'])) {
    $stmt = $conn->prepare("UPDATE tarefas SET concluida = 1 WHERE id = :id");
    $stmt->bindValue(':id', $_GET['concluir'], SQLITE3_INTEGER);
    $stmt->execute();
    header('Location: index.php');
    exit();
}

if (isset($_GET['excluir'])) {
    $stmt = $conn->prepare("DELETE FROM tarefas WHERE id = :id");
    $stmt->bindValue(':id', $_GET['excluir'], SQLITE3_INTEGER);
    $stmt->execute();
    header('Location: index.php');
    exit();
}

$result = $conn->query("SELECT * FROM tarefas ORDER BY data_vencimento ASC");
$tarefas_pendentes = [];
$tarefas_concluidas = [];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    if ($row['concluida']) {
        $tarefas_concluidas[] = $row;
    } else {
        $tarefas_pendentes[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <style>
     body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f7fc;
            color: #333;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 600;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        form input, form button {
            margin: 10px 0;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
        }
        form input:focus, form button:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        form input::placeholder {
            color: #999;
        }
        form button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #0056b3;
        }
        .tarefa {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            margin-bottom: 15px;
            width: 100%;
            max-width: 450px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            align-items: center;
            transition: transform 0.3s ease;
        }
        .tarefa:hover {
            transform: translateY(-5px);
        }
        .tarefa span {
            font-size: 14px;
            color: #666;
        }
        .concluir, .excluir {
            font-size: 14px;
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .concluir {
            background-color: #28a745;
            color: white;
        }
        .concluir:hover {
            background-color: #218838;
        }
        .excluir {
            background-color: #dc3545;
            color: white;
        }
        .excluir:hover {
            background-color: #c82333;
        }
        .tarefa .concluir, .tarefa .excluir {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h2>Adicionar Nova Tarefa</h2>
    <form method="POST">
        <input type="text" name="descricao" placeholder="Descrição" required>
        <input type="date" name="data_vencimento" required>
        <button type="submit">Adicionar</button>
    </form>

    <h2>Lista de Tarefas Pendentes</h2>
    <?php foreach ($tarefas_pendentes as $tarefa): ?>
        <div class="tarefa">
            <?= htmlspecialchars($tarefa['descricao']) ?> - <?= date('d/m/Y', strtotime($tarefa['data_vencimento'])) ?>
            <a href="?concluir=<?= $tarefa['id'] ?>" class="concluir">Concluir</a>
            <a href="?excluir=<?= $tarefa['id'] ?>" class="excluir">Excluir</a>
        </div>
    <?php endforeach; ?>

    <h2>Lista de Tarefas Concluídas</h2>
    <?php foreach ($tarefas_concluidas as $tarefa): ?>
        <div class="tarefa">
            <?= htmlspecialchars($tarefa['descricao']) ?> - <?= date('d/m/Y', strtotime($tarefa['data_vencimento'])) ?>
            <span style="color: green;">Concluída</span>
            <a href="?excluir=<?= $tarefa['id'] ?>" class="excluir">Excluir</a>
        </div>
    <?php endforeach; ?>
</body>
</html>