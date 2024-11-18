<?php

$query = $pdo->query("SELECT * FROM livros ORDER BY id DESC");
$livros = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Livraria</title>
    <style>
        body {
            background-color:#ddd
        }

        h1 {
            text-align: center;
            color: #444;
            margin-top: 20px;
        }

        form {
            margin: 20px auto;
            padding: 15px;
            width: 400px;
            background: #fff;
            border-radius: 8px;
        }

        form h2 {
            text-align: center;
        }

        form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
        }

        table th, table td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
            color: #555;
            font-weight: bold;
        }

        table button {
            width:80%;
            padding: 5px 10px;
            background-color: #d9534f;
            cursor: pointer;
            font-size: 14px;
        }

        table button:hover {
            background-color: #c9302c;
        }

        /* Centralização */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Livraria</h1>

        <!-- Formulário para adicionar livros -->
        <form method="POST">
            <h2>Adicionar Livro</h2>
            <input type="text" name="titulo" placeholder="Título" required>
            <input type="text" name="autor" placeholder="Autor" required>
            <input type="number" name="ano_publicacao" placeholder="Ano de Publicação" required>
            <button type="submit">Adicionar Livro</button>
        </form>

        <!-- Lista de livros cadastrados -->
        <h2 style="text-align: center;">Lista de Livros</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Ano de Publicação</th>
                <th>Excluir</th>
            </tr>
            <?php foreach ($livros as $livro): ?>
                <tr>
                    <td><?= $livro['id'] ?></td>
                    <td><?= htmlspecialchars($livro['titulo']) ?></td>
                    <td><?= htmlspecialchars($livro['autor']) ?></td>
                    <td><?= $livro['ano_publicacao'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?= $livro['id'] ?>">
                            <button type="submit" onclick="return confirm('Deseja realmente excluir este livro?');">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>