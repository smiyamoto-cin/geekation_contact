<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
  header('Location: index.php');
  exit;
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
  <title>完了画面</title>
</head>

<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 mt-3 mb-1">
        <h1 class="text-center">完了画面</h1>
      </div>
      <div class="col-md-12 mt-3 mb-1">
        <p class="text-center">お問い合わせ内容を送信しました。 <br>ありがとうございました。</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-2 m-1">
        <button type="button" onclick="location.href='/'" name="back" class="btn btn-primary btn-block">トップに戻る</button>
      </div>
    </div>
  </div>

</body>

</html>