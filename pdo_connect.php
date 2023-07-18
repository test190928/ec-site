<?php

//ロリポップ用
//$dsn = "mysql:dbname=LAA1400590-portfolio;host=mysql202.phy.lolipop.lan;charset=utf8";
//$user = "LAA1400590";
//$password = "donadonasonnna50";

//ローカル
$dsn = "mysql:host=127.0.0.1;dbname=ec_site";
$user = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $user, $password);
//     echo "<p>接続成功</p>";
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
