<?php

// 先ほど作成したPDOインスタンス作成をそのまま使用します
require 'pdo_connect.php';

// SQL文を準備します。「:id」がプレースホルダーです。
$sql = 'SELECT * FROM user WHERE id < :id';
// PDOStatementクラスのインスタンスを生成します。
$prepare = $dbh->prepare($sql);

// PDO::PARAM_INTは、SQL INTEGER データ型を表します。
// SQL文の「:id」を「3」に置き換えます。つまりはidが3より小さいレコードを取得します。
$prepare->bindValue(':id', 3, PDO::PARAM_INT);

// プリペアドステートメントを実行する
$prepare->execute();

// PDO::FETCH_ASSOCは、対応するカラム名にふられているものと同じキーを付けた 連想配列として取得します。
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

// 結果を出力
var_dump($result);
