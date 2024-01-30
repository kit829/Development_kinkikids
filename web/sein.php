<?php
session_start();
if(isset($_POST["id"])&isset($_POST["id"])){
    $_SESSION["id"] = $_POST["id"];
    $_SESSION["family_id"] = $_POST["fid"];
    echo "ユーザーID=".$_POST["id"];
    echo "<br>";
    echo "家族ID=".$_POST["fid"];
    echo "<br>";
}

?>
<form action="" method="post">
    ユーザーID<input type="int" name="id" value="8"><br>
    家族ID<input type="int" name="fid" value="8"><br>
    <button type = "submit">ID変更</button>
</form>