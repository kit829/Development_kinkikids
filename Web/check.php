<?php
require("./dbconnect.php");
session_start();
 
/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: entry.php');
    exit();
}
 
if (!empty($_POST['check'])) {
    // パスワードを暗号化
    $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
    
    $statement = $db->prepare("INSERT INTO family SET family_name=?");
    $statement->execute(array(
        $_SESSION['join']['family_name'],
    ));
 
    $statement = $db->prepare('SELECT * FROM family WHERE family_name=?');
    $statement->execute(array(
        $_SESSION['join']['family_name'],
    ));

    $record = $statement->fetch(PDO::FETCH_ASSOC);

    if ($record !== false) {
        end($record);
        $family_id = $record['family_id'];
    } else {
        $family_id = null;
        error_log('Fetch failed in check.php');
    }
    $family_id = $record['family_id'];

    // 入力情報をデータベースに登録
    $statement = $db->prepare(
        // "INSERT INTO user 
        // SET username=?, password=?, first_name=?, last_name=?, birthday=?, gender_id=?, role_id=?, savings=?, family_id"
        "INSERT INTO user 
        (username, password, first_name, last_name, birthday, gender_id, role_id, savings, family_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $statement->execute(array(
        $_SESSION['join']['username'],
        $hash,
        $_SESSION['join']['first_name'],
        $_SESSION['join']['last_name'],
        $_SESSION['join']['birthday'],
        $_SESSION['join']['gender_id'],
        $_SESSION['join']['role_id'],
        $_SESSION['join']['savings'],
        $family_id
    ));

 
    unset($_SESSION['join']);   // セッションを破棄
    header('Location: thank.php');   // thank.phpへ移動
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>確認画面</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
            <h1>入力情報の確認</h1>
            <p>ご入力情報に変更が必要な場合、下のボタンを押し、変更を行ってください。</p>
            <p>登録情報はあとから変更することもできます。</p>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>
            <hr>
 
            <div class="control">
                <p>ユーザーネーム</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['username'], ENT_QUOTES); ?></span></p>
            </div>
 
            <div class="control">
                <p>名前</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['first_name'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p>名字</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['last_name'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p>生年月日</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['birthday'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p>手持ち金額</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['savings'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p>家族名</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['family_name'], ENT_QUOTES); ?></span></p>
            </div>
            
            <br>
            <a href="entry.php" class="back-btn">変更する</a>
            <button type="submit" class="btn next-btn">登録する</button>
            <div class="clear"></div>
        </form>
    </div>
</body>
</html>