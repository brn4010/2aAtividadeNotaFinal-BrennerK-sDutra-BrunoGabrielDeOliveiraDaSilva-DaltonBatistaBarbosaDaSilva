<?php
class Database extends SQLite3 {
    function __construct() {
        $this->open('tarefas.db');
    }
}

$conn = new Database();
?>
