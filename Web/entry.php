<!-- ユーザー登録ページ -->
<?php 
require("./dbconnect.php");
session_start();
 
if (!empty($_POST)) {
    /* 入力情報に空白がないか検知 */
    if ($_POST['username'] === "") {
        $error['username'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }
    if ($_POST['first_name'] === "") {
        $error['first_name'] = "blank";
    }
    if ($_POST['last_name'] === "") {
        $error['last_name'] = "blank";
    }
    if ($_POST['birthday'] === "") {
        $error['birthday'] = "blank";
    }
    if ($_POST['gender_id'] === "") {
        $error['gender_id'] = "blank";
    }
    if ($_POST['role_id'] === "") {
        $error['role_id'] = "blank";
    }
    if ($_POST['role_id'] === "") {
        $error['role_id'] = "blank";
    }
    if ($_POST['family_name'] === "") {
        $error['family_name'] = "blank";
    }

    /* usernameの重複を検知 */
    if (!isset($error)) {
        $user = $db->prepare('SELECT COUNT(*) as cnt FROM user WHERE username=?');
        $user->execute(array(
            $_POST['username']
        ));
        $record = $user->fetch();
        if ($record['cnt'] > 0) {
            $error['username'] = 'duplicate';
        }
    }
 
    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: check.php');   // check.phpへ移動
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>アカウント作成</title>
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <h1>アカウント作成</h1>
            <p>当サービスをご利用するために、次のフォームに必要事項をご記入ください。</p>
            <br>
 
            <div class="control">
                <label for="username">ユーザー名</label>
                <input id="username" type="text" name="username">
            </div>
 
            <div class="control">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password">
                <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
                    <p class="error">＊パスワードを入力してください</p>
                <?php endif ?>
            </div>

            <div class="control">
                <label for="last_name">苗字</label>
                <input id="last_name" type="text" name="last_name">
            </div>

            <div class="control">
                <label for="first_name">名前</label>
                <input id="first_name" type="text" name="first_name">
            </div>

            <div class="control">
                <label for="birthday">誕生日</label>
                <input id="birthday" type="date" name="birthday">
            </div>

            <!-- DBの負担を減らすためプルダウンは手入力 -->
            <div class="control">
                <label for="gender_id">性別</label>
                <select name="gender_id" id="gender_id">
                    <option value="1">女性</option>
                    <option value="2">男性</option>
                    <option value="3">その他</option>
                </select>
            </div>

            <div class="control">
                <label for="role_id">役割</label>
                <select name="role_id" id="role_id">
                <!-- 「FIXME」ログインされていない場合は管理者の役割しか選べないように修正する -->
                <?php
                    $stmt = $db->query("SELECT role_id,role_name FROM role");
                    foreach($stmt as $record){
                        echo '<option value="';
                        echo $record[0];
                        echo '">';
                        echo $record[1];
                        echo "</option>";
                    }
                ?>
                </select>
            </div>

            <div class="control">
                <label for="savings">貯蓄</label>
                <input id="savings" type="int" name="savings">
            </div>
            
            <!-- 「FIXME」管理ユーザーがログインしている場合は表示しないようにする -->
            <div class="control">
                <label for="family_name">家族名</label>
                <input id="family_name" type="text" name="family_name">
            </div>
 
            <div class="control">
                <button type="submit" class="btn">確認する</button>
            </div>
        </form>
    </div>
</body>
</html>