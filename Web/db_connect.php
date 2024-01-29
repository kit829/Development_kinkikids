<?php
// test
class connect extends PDO {
    const DB_NAME = "kinkikids";
    const HOST = "127.0.0.1";
    const USER = "root";
    const PASS = "";

    public function __construct(){
        $dsn = "mysql:host=".self::HOST.";dbname=".self::DB_NAME.";charset=utf8mb4";
        try {
            // 親クラスのコンストラクタを呼び出す
            parent::__construct($dsn, self::USER, self::PASS);
        } catch(Exception $e){
            exit($e->getMessage());
        }

        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
}
?>