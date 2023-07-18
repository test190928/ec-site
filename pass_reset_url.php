<?php
require 'pdo_connect.php';
require "common.php";

session_start();
//ログイン済みの場合
if (isset($_SESSION['USER'])) {
    header("Location: product_list.php");
}

$url_pass = $_GET["name"];

//10分前の時刻を取得
$datetime = new DateTime('- 10 min');
//プレースホルダで SQL 作成
$sql = "SELECT * FROM User_Info WHERE temp_pass = ? AND temp_limit_time >= ?";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $url_pass, PDO::PARAM_STR);
$stmt->bindValue(2, $datetime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($row)) {
    $_SESSION['error_status'] = 4;
    header("location: pass_reset.php");
}

$_SESSION['url_pass'] = $url_pass;

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
                    echo '<h4 style="color:red;">パスワードが一致しません。</h4>';
                }
                ?>
                <form  action="pass_reset_submit.php" method="post">
                    <label for="email">新しいパスワード</label>
                    <input type="password" name="password" placeholder="新しいパスワード">
                    <label for="email">新しいパスワード(確認)</label>
                    <input type="password" name="confirm_password" placeholder="新しいパスワード">
                    <input type="hidden" name="email" value="<?php echo $row["Email_Address"] ?>">
                    <button type="submit" class="submit">保存</button>
                    <a href="index.php" class="cancel">キャンセル</a>
                </form>
            </div>
		</div>
	</div>

</body>
</html>
