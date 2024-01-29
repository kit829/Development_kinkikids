<?php
class connect{
    const DB_NAME = "kinkikids";
    const HOST = "127.0.0.1";
    const USER = "root";
    const PASS = "";

    private $dbh;

    public function __construct(){
        $dsn = "mysql:host=".self::HOST.";dbname=".self::DB_NAME.";charset=utf8mb4";
        try {
            // PDOのインスタンスをクラス変数に格納する
            $this->dbh = new PDO($dsn, self::USER, self::PASS);
      
          } catch(Exception $e){
            // Exceptionが発生したら表示して終了
            exit($e->getMessage());
          }

        // DBのエラーを表示するモードを設定
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
}
?>