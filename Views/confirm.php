
<?php 
session_start();
//ダイレクトアクセス禁止
if (!isset($_SERVER['HTTP_REFERER'])) {
  header('Location: index.php');
  exit;
}

require_once ('../Controllers/ContactController.php');    
$instance = new ContactController();
$instance->confirm();

$fullname = '';
$furigana = '';
$tel = '';
$email = '';
$message = '';

// 保存された入力値を表示
if (isset($_SESSION['fullname'])) {
    $fullname = htmlspecialchars($_SESSION['fullname'], ENT_QUOTES, 'UTF-8');
}
if (isset($_SESSION['furigana'])) {
    $furigana = htmlspecialchars($_SESSION['furigana'], ENT_QUOTES, 'UTF-8');
}
if (isset($_SESSION['tel'])) {
    $tel = htmlspecialchars($_SESSION['tel'], ENT_QUOTES, 'UTF-8');
}
if (isset($_SESSION['email'])) {
    $email = htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8');
}
if (isset($_SESSION['message'])) {
    $message = htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>確認画面</title>
</head>
<body>

<div class="container">
		<form method="post" action="confirm.php">
			<div class="row justify-content-center">
      <div class="col-md-12 mt-3 mb-1">
			<h1 class ="text-center">確認画面</h1>
			</div>
				<div class="col-md-8 mt-3 mb-1">
					<label for="fullname">氏名</label>
					<input type="text" name='fullname' class="form-control" id="full" placeholder="氏名"
						value="<?php  echo $fullname ?>" required>
				</div>
				<div class="col-md-8 m-1">
					<label for="furigana">フリガナ</label>
					<input type="text" name='furigana' class="form-control" id="furigana" placeholder="フリガナ"
						value="<?php  echo $furigana ?>" required>
				</div>
				<div class="col-md-8 m-1">
					<label for="tel">電話番号</label>
					<input type="text" name='tel' class="form-control" id="tel" placeholder="電話番号"
						value="<?php  echo $tel?>" pattern="[0-9]*">
				</div>
				<div class="col-md-8 m-1">
					<label for="email">メールアドレス</label>
					<input type="text" name='email' class="form-control" id="email" placeholder="メールアドレス"
						value="<?php  echo $email ?>" required>
				</div>
				<div class="col-md-8 mt-1">
					<label for="message">お問い合わせ内容</label>
					<pre><textarea name='message' class="form-control" id="message" placeholder="お問い合わせ内容" required><?php  echo $message ?></textarea></pre>
					
				</div>
			</div>
			<!-- ボタンブロッック -->
			<div class="row justify-content-center">
				<div class="col-md-2 m-1">
					<button type="button" onclick="location.href='contact.php'" name="back"
						class="btn btn-primary btn-block">キャンセル</button>
				</div>
				<div class="col-md-2 m-1">
					<form name="myForm" action="/contact" method="POST" onsubmit="return validateForm()">
						<button type="submit" name="confirm" class="btn btn-primary btn-block">登録</button>
				</div>
			</div>
		</form>
  </div>
</body>
</html>