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

<?php

//登録処理
if(isset($_GET["name"])){
    if($_GET["name"] == "signUp"){

        if(empty($_POST["userName"])){
            echo "ユーザー名を入力してください";
        }else {
            $userName = $_POST["userName"];
        }

        //POSTのValidate
        if(!$email = filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
            echo "入力された値が不正です";
        }

        //パスワードの正規表現
        if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST["password"])){
            $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        }else {
            echo "パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。";
        }

        if(!empty($email) && !empty($password) && !empty($userName)){
            try {
                $stmt = $dbh->prepare("insert into User_Info(User_Name, Email_Address, Login_Pass) value(?, ?, ?)");
                $stmt->execute([$userName, $email, $password]);
                echo '登録完了';
            }catch(\Exception $e){
                echo '登録済みのメールアドレスです。';
            }
        }

    }
}

?>

<?php

//ログイン処理
if(isset($_GET["name"])){
    if($_GET["name"] == "login"){
        //POSTのvalidate
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo '入力された値が不正です。';
        }
        //DB内でPOSTされたメールアドレスを検索
        try {
            $stmt = $dbh->prepare('select * from User_Info where Email_Address = ?');
            $stmt->execute([$_POST['email']]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        //emailがDB内に存在しているか確認
        if (!isset($row['Email_Address'])) {
            echo 'メールアドレス又はパスワードが間違っています。';
        }
        //パスワード確認後sessionにメールアドレスを渡す
        else if (password_verify($_POST['password'], $row['Login_Pass'])) {
            session_regenerate_id(true); //session_idを新しく生成し、置き換える
            $_SESSION['USER'] = $row['User_Name'];
            $_SESSION['ID'] = $row['User_ID'];
            $_SESSION['RIGHT'] =$row['User_Right'];
            $_SESSION['CART'] = array();
            $_SESSION["TOKEN"] = get_csrf_token();
            header("Location:product_list.php");
            echo 'ログインしました<a href="product_list.php">トップへ</a>';
        } else {
            echo 'メールアドレス又はパスワードが間違っています。';
        }

    }
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
    			<h1>ログイン</h1>
                <form  action="index.php?name=login" method="post">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" placeholder="メールアドレス" value="sample01.portfolio@gmail.com">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" placeholder="パスワード" value="sample0101">
                    <button type="submit" class="submit">ログイン</button>
                    <a href="pass_reset.php" class="reset">パスワードを忘れた場合</a>
                    <a href="signUp_page.php" class="create">アカウントを作成</a>
                </form>
            </div>
		</div>
	</div>

</body>
</html>
