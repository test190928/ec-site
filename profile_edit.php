<?php

require "pdo_connect.php";
session_start();

$prepare = $dbh->prepare("SELECT * FROM User_Info WHERE User_ID=?");
$prepare->execute([$_SESSION["ID"]]);
$user = $prepare->fetchAll(PDO::FETCH_ASSOC);

$error = '';
if (@$_POST['submit']) {
    $userName = $_POST['userName'];
    $mailAddress = $_POST['mailAddress'];
    if (!$userName) $error .= '商品名がありません。<br>';
    if (!$mailAddress) $error .= 'カテゴリ名がありません。<br>';
    if (!$error) {
        try {
            $prepare = $dbh->prepare("UPDATE User_Info SET User_Name='$userName', Email_Address='$mailAddress' WHERE User_ID=?");
            $prepare->execute([$_SESSION["ID"]]);
            header('Location: account.php?name=update');
            exit();
        }catch(\Exception $e){

        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>会員情報</title>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/account.css">
</head>
<body>
	<?php require 'nav.php'; ?>
	<?php require 'search_area.php'; ?>

	<div class="container">

		<div class="profile-area profile-edit-area">
			<form action="profile_edit.php" method="post">
    			<h3 class="profile-title">プロフィール編集</h3>
    			<div class="clear"></div>
    			<p>ユーザー名</p>
    			<input type="text" name="userName" value="<?php echo $user[0]["User_Name"] ?>" class="profile-edit-input">
    			<p>メールアドレス</p>
    			<input type="text" name="mailAddress" value="<?php echo $user[0]["Email_Address"] ?>" class="profile-edit-input">
    			<input type="submit" value="保存" name="submit" class="profile-edit-submit">
    			<a href="account.php" class="profile-edit-cancel">キャンセル</a>
			</form>
		</div>

	</div>

	<?php require 'footer.php'; ?>
    <script src="js/popup.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</body>
</html>