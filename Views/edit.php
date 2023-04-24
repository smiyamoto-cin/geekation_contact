<?php
session_start();
require_once ('../Controllers/ContactController.php');     

$instance = new ContactController();
$params = $instance->index();
$instance->edit();

$id = isset($_GET['id'])?(int)$_GET['id'] : null;
if(!$id){
    exit;
}
//SQL準備
$dbh =(new DbModel())->dbConnect();
$stmt =$dbh->prepare('SELECT * FROM contacts WHERE id = :id');
$stmt->bindValue(':id',(int)$id,PDO::PARAM_INT);
//SQl実行
$stmt->execute();
//結果を取得
$result =$stmt->fetch(PDO::FETCH_ASSOC);

$id =$result['id'];
$fullname =$result['name'];
$furigana =$result['kana'];
$tel =$result['tel'];
$email =$result['email'];
$message =$result['body'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>編集画面</title>
</head>
  <body>
  <div class="container">
      <form method="post" action="edit.php">
      <!-- 更新 -->
      <input type="hidden" name="id" value="<?= $id; ?>">
        <div class="row justify-content-center">
        <div class="col-md-12 mt-3 mb-1">
        <h1 class ="text-center">更新画面</h1>
        </div>
          <div class="col-md-8 mt-3 mb-1">
            <label for="fullname">氏名</label>
            <input type="text" name='fullname' class="form-control" id="full" placeholder="氏名" value="<?= $fullname;?>" required>
          </div>
          <div class="col-md-8 m-1">
            <label for="furigana">フリガナ</label>
            <input type="text" name='furigana' class="form-control" id="furigana" placeholder="フリガナ" value="<?= $furigana;?>" required>
          </div>
          <div class="col-md-8 m-1">
            <label for="tel">電話番号</label>
            <input type="text" name='tel' class="form-control" id="tel" placeholder="電話番号"
            value="<?= $tel;?>" pattern="[0-9]*">
          </div>
          <div class="col-md-8 m-1">
            <label for="email">メールアドレス</label>
            <input type="text" name='email' class="form-control" id="email" placeholder="メールアドレス"
            value="<?= $email;?>" required>
          </div>
          <!-- テキストエリア -->
          <div class="col-md-8 mt-1">
            <label for="Textarea">お問い合わせ内容</label>
            <pre><textarea class="form-control" name='message' id="Textarea" placeholder="お問い合わせ内容" required><?= $message;?></textarea></pre>
            
          </div>
          <div class="col-md-8 mt-1">
            <label for="Textarea">上記の内容でよろしいですか？</label>
          </div>
          
        </div>
        <!-- ボタンブロッック -->
        <div class="row justify-content-center">
        
          <div class="col-md-2 m-1">
            <button type="button" onclick="location.href='contact.php'" name="back" class="btn btn-primary btn-block">キャンセル</button>
          </div>


          <div class="col-md-2 m-1">
            <form name="myForm" action="/contact" method="POST" onsubmit="return validateForm()">
              <button type="submit" name="confirm" value="更新" class="btn btn-primary btn-block">更新</button>
          </div>
        </div>
    </div>
    </form>
    </div>
  </body>
</html>
