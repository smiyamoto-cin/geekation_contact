<?php
session_start();
require_once('../Controllers/ContactController.php');

$instance = new ContactController();
$params = $instance->index();
//var_dump($params);
$instance->contact();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<title>入力画面</title>
</head>

<body>
	<div class="container">
		<form method="post" action="contact.php">
			<div class="row justify-content-center">
			<div class="col-md-12 mt-3 mb-1">
			<h1 class ="text-center">入力画面</h1>
			</div>
				<div class="col-md-8 mt-3 mb-1">
					<label for="fullname">氏名</label>
					<input type="text" name='fullname' class="form-control" id="full" placeholder="氏名"
						value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>" required>
				</div>
				<div class="col-md-8 m-1">
					<label for="furigana">フリガナ</label>
					<input type="text" name='furigana' class="form-control" id="furigana" placeholder="フリガナ"
						value="<?php echo isset($_SESSION['furigana']) ? $_SESSION['furigana'] : ''; ?>" required>
				</div>
				<div class="col-md-8 m-1">
					<label for="tel">電話番号</label>
					<input type="text" name='tel' class="form-control" id="tel" placeholder="電話番号"
						value="<?php echo isset($_SESSION['tel']) ? $_SESSION['tel'] : ''; ?>" pattern="[0-9]*">
				</div>
				<div class="col-md-8 m-1">
					<label for="email">メールアドレス</label>
					<input type="text" name='email' class="form-control" id="email" placeholder="メールアドレス"
						value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
				</div>
				<div class="col-md-8 mt-1">
					<label for="message">お問い合わせ内容</label>
					<pre><textarea name='message' class="form-control" id="message" placeholder="お問い合わせ内容" required><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?></textarea></pre>
				</div>
			</div>
			<!-- ボタンブロッック -->
			<div class="row justify-content-center">
				<div class="col-md-2 m-1">
					<button type="button" onclick="location.href='/'" name="back"
						class="btn btn-primary btn-block">戻る</button>
				</div>
				<div class="col-md-2 m-1">
					<form name="myForm" action="/contact" method="POST" onsubmit="return validateForm()">
						<button type="submit" name="confirm" class="btn btn-primary btn-block">確認</button>
				</div>
			</div>
		</form>

		<!-- 一覧表示 -->
		<div class="row justify-content-center">
			<table class="table table-bordered table table-sm">
				<tr class="table-dark">
					<th nowrap>氏名</th>
					<th nowrap>フリガナ</th>
					<th>電話番号</th>
					<th>メールアドレス</th>
					<th>お問い合わせ内容</th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach ($params['contacts'] as $instance): ?>
					<tr>
						<td nowrap>
							<?php echo htmlspecialchars($instance['name'], ENT_QUOTES, 'UTF-8'); ?>
						</td>
						<td nowrap>
							<?php echo htmlspecialchars($instance['kana'], ENT_QUOTES, 'UTF-8'); ?>
						</td>
						<td>
							<?php echo htmlspecialchars($instance['tel'], ENT_QUOTES, 'UTF-8'); ?>
						</td>
						<td>
							<?php echo htmlspecialchars($instance['email'], ENT_QUOTES, 'UTF-8'); ?>
						</td>
						<td>
							<?php echo nl2br(htmlspecialchars($instance['body'], ENT_QUOTES, 'UTF-8'), false); ?>
						</td>
						<td nowrap><a href="edit.php?id=<?= $instance['id'] ?>">編集</a></td>
						<td nowrap><a href="delete.php?id=<?= $instance['id'] ?>"
								onclick="return confirm('本当に削除しますか？')">削除</a></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</body>
<script>
	const myTextarea = document.getElementById('myTextarea');
	myTextarea.addEventListener('input', () => {
		localStorage.setItem('myTextarea', myTextarea.value);
	});
	window.addEventListener('load', () => {
		const myTextarea = document.getElementById('myTextarea');
		const savedText = localStorage.getItem('myTextarea');
		if (savedText !== null) {
			myTextarea.value = savedText;
		}
	});
</script>

</html>