<?php
require 'pdo_connect.php';

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
    			<h1>アカウントを作成</h1>
                <form action="index.php?name=signUp" method="post">
                	<label for="userName">ユーザー名</label>
                    <input type="text" name="userName" placeholder="ユーザー名">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" placeholder="メールアドレス">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" placeholder="パスワード">
                    <button type="submit" class="submit">登録</button>
                </form>
            </div>
		</div>
	</div>


<!--     <h1>初めての方はこちら</h1>
    <form action="index.php?name=signUp" method="post">
    	<label for="userName">ユーザー名</label>
        <input type="text" name="userName">
        <label for="email">email</label>
        <input type="email" name="email">
        <label for="password">password</label>
        <input type="password" name="password">
        <button type="submit">Sign Up</button>
        <p>※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
    </form> -->

</body>
</html>