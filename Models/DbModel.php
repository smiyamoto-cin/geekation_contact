<?php
require_once('../database.php');

class DbModel{
    protected $dbh; //クラス内で使うプロパティ「$dbh」を宣言しています。この変数は、データベース接続を行うためのPDOオブジェクトを保持します。
    
    public function __construct($dbh =null){
        if(!$dbh){ //接続情報がぞんざいしない場合
            try{
                $this->dbh =new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASSWD);
                //接続成功
            } catch (PDOException $e){
                echo "接続失敗: " . $e->getMessage() . "\n";
                exit();
            }  
        } else {//接続情報が存在する場合
            $this->dbh = $dbh;
        }
    }

    public function get_db_handler(){
        return $this->dbh;
    }

    public function begin_transaction(){
        $this->dbh->beginTransaction();
    }

    public function commit(){
        $this->dbh->commit();
    }

    public function rollback(){
        $this->dbh->rollback();
    }
    
    
    
    public function dbConnect()
    {
        $host =DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASSWD;

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            $dbh = new \PDO($dsn, $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]);

        } catch (\PDOException $e) {
            echo '接続失敗' . $e->getMessage();
            exit();
        };
        return $dbh;
    }

}

?>
