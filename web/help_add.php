<?php 
// test
session_start();
require("./db_connect.php");
require("./help_class.php");
// データベース接続を行う
$db = new connect();
// entryクラスのインスタンスを作成
$help = new help($db);

$help->add_help();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>お手伝い登録</title>
</head>
<body>
    <form action="" method="post">
        お手伝い名<input type="text" name="id"><br>
        お手伝い詳細<input type="text" name="help_"><br>
        獲得ポイント<input type="int" name="get_point"><br>
        <button type = "submit">登録</button>
    </form>
</body>
</html>