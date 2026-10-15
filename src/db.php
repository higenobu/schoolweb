<?php
require_once __DIR__.'/../config.php';

function query(string $sql, array $params = []): PDOStatement {
    global $pdo;
    return $pdo->prepare($sql)->execute($params);
}
?>
