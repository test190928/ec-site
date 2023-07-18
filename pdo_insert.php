<?php

require 'pdo_connect.php';

// SQL文を準備します。「:id」「:name」がプレースホルダーです。
$sql = 'INSERT INTO user (id, name) VALUE (:id, :name)';
$prepare = $dbh->prepare($sql);

$prepare->bindValue(':id', 4, PDO::PARAM_INT);
$prepare->bindValue(':name', 'kobayashi', PDO::PARAM_STR);
$prepare->execute();

// INSERTされたデータを確認します
$sql = 'SELECT * FROM user';
$prepare = $dbh->prepare($sql);

$prepare->execute();

$result = $prepare->fetch(PDO::FETCH_NUM);
print($result[0]);
print($result[1]);