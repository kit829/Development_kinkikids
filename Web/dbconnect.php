<?php
try {
    $db = new PDO('mysql:dbname=kinkikids;host=127.0.0.1;charset=utf8mb4', 'root', '');
}   catch (PDOException $e) {
    echo "データベース接続エラー：".$e->getMessage();
}
?>