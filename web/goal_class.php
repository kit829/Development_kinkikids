<?php
// test
class entry{
    private $error; // エラー情報を保持するプロパティ
    private $db; // データベース接続を保持するプロパティ

    function __construct($db){
        $this->db = $db;
        $this->error = []; // 初期化

        if (!empty($_POST)) {
            /* 入力情報に空白がないか検知 */
            if ($_POST['target_amount'] === "") {
                $error['target_amount'] = "blank";
            }
            if ($_POST['goal_detail'] === "") {
                $error['goal_detail'] = "blank";
            }
            if ($_POST['goal_deadline'] === "") {
                $error['goal_deadline'] = "blank";
            }
            
            // エラーがなければ次のページへ
            if (!isset($error)) {
                // フォームの内容をセッションで保存
                $_SESSION['join'] = $_POST;

                // ログインしているユーザーのIDを取得
                $user_id = $_SESSION["user_id"];

                // ログインしているユーザーのfamily_idを取得
                $family_id = $this->getFamilyId($user_id);

                // 現在の日時を取得
                $goal_created_date = date("Y-m-d H:i:s");

                // データベースに挿入する際に、user_id、family_id、goal_created_dateを追加
                $_SESSION['join']['user_id'] = $user_id;
                $_SESSION['join']['family_id'] = $family_id;
                $_SESSION['join']['goal_created_date'] = $goal_created_date;

                // check.phpへ移動
                header('Location: goal_check.php');
                exit();
            }
        }
    }

    public function role_select(){
        // $this->db が null でないことを確認
        if ($this->db !== null) { 
            $stmt = $this->db->query("SELECT role_id,role_name FROM role");
            foreach($stmt as $record){
                echo '<option value="';
                echo $record[0];
                echo '">';
                echo $record[1];
                echo "</option>";
            }
        }
    }

    // ユーザーのfamily_idを取得する関数
    private function getFamilyId($user_id){
        $stmt = $this->db->prepare("SELECT family_id FROM user WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['family_id'];
    }
}

?>
