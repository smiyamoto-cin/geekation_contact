<?php

require_once('DbModel.php');

class Contact extends DbModel {
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }
/**
 * contactsテーブルから全てのデータを取得(20件ごと)
 */

    public function findAll():Array{
        $connect = new DbModel();
        $dbh= $connect ->dbConnect();
        $sql = 'SELECT * FROM contacts;';
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

Class ContactModel
{
    public function create($request){
        
        $result = true;

        //DbModelをインスタンス化
        // dbConnect経由でcontanctsテーブルにデータを挿入
        // →登録成功
        // return $result
        // →登録失敗 
        // $result = false;
        // return $result;
        $connect =new DbModel();
        $dbh= $connect ->dbConnect();
        $sql = 'INSERT INTO contacts(name, kana, tel, email, body) 
                VALUES ("'.$request['fullname'].'","'.$request['furigana'].'","'.$request['tel'].'","'.$request['email'].'","'.$request['message'].'")';
        $dbh->beginTransaction();          
        try {
            //$dbh->query($sql);
            $stmt =$dbh->prepare($sql);
            $stmt->execute();
            $dbh->commit();
        } catch(PDOException $e){
            $dbh->rollBack();
            $result = false;
        }

        return $result;
    }

    //更新
    public function update($request){
        
        $result = true;
        $connect =new DbModel();
        $dbh= $connect ->dbConnect();
        $sql = "UPDATE contacts SET name= :name, kana= :kana, tel= :tel, email= :email, body= :body
                WHERE id =:id"; 

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dbh->beginTransaction();     
        try {
            //$dbh->query($sql);
            $stmt =$dbh->prepare($sql);
            //$stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $request['fullname'], PDO::PARAM_STR);
            $stmt->bindValue(':kana', $request['furigana'], PDO::PARAM_STR);
            $stmt->bindValue(':tel', $request['tel'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $request['email'], PDO::PARAM_STR);
            $stmt->bindValue(':body', $request['message'], PDO::PARAM_STR);
            $stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
        } catch(PDOException $e){
            $dbh->rollBack();
            $result = false;
        }

        return $result;
        
    }

        //削除
        public function delete($request){
        
            $result = true;
            $connect =new DbModel();
            $dbh= $connect ->dbConnect();
            $stmt =$dbh->prepare("DELETE FROM contacts WHERE id = :id");
            $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                header('Location: contact.php');
                exit;
            }
            return $result;
        }
}
?>