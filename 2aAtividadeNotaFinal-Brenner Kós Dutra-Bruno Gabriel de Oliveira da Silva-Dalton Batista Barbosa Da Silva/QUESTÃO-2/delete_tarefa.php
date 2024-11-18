<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM tarefas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();
    
    header('Location: index.php');
}
?>
