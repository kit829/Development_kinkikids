<?php
session_start();
require("./db_connect.php");
require("./help_class.php");

$db = new connect();
$help = new help($db);

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>お手伝い登録</title>
</head>
<body>
    <form action="help_add.php" method="post">
        お手伝い名<input type="text" name="help_name"><br>
        お手伝い詳細<input type="text" name="help_detail"><br>
        獲得ポイント<input type="number" name="get_point"><br>
        <button type="submit">登録</button>
    </form>

    <?php
    // 登録されたお手伝いの一覧を表示
    $help->display_help();
    ?>
</body>
</html>
