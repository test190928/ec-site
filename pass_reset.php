<?php
require 'pdo_connect.php';
require "common.php";

function h($s){
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
//ログイン済みの場合
if (isset($_SESSION['USER'])) {
    header("Location: product_list.php");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

	<div class="container">
		<div class="login-area">
			<div class="align">
                <h1>パスワードリセット</h1>

                <?php
                    if (@$_SESSION['error_status'] == 1) {
                        echo "<h4 style='color:red;'>パスワードをリセットしてください。</h4>";
                    }
                    if (@$_SESSION['error_status'] == 2) {
                        echo "<h4 style='color:red;'>入力内容に誤りがあります。</h4>";
                    }
                    if (@$_SESSION['error_status'] == 3) {
                        echo "<h4 style='color:red;'>不正なリクエストです。</h4>";
                    }
                    if (@$_SESSION['error_status'] == 4) {
                        echo '<h4 style="color:red;">タイムアウトか不正なURLです。</h4>';
                    }
                    //エラー情報のリセット
                    $_SESSION['error_status'] = 0;
                ?>

                <form  action="pass_reset_mail.php" method="post">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" placeholder="メールアドレス">
                    <button type="submit" class="submit">メールを送信する</button>
                    <a href="index.php" class="cancel">キャンセル</a>
                </form>
            </div>
		</div>
	</div>

</body>
</html>
