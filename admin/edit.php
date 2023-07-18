<?php
require '../pdo_connect.php';
$error = '';
if (@$_POST['submit']) {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $comment = $_POST['comment'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    if (!$name) $error .= '商品名がありません。<br>';
    if (!$category) $error .= 'カテゴリ名がありません。<br>';
    if (!$comment) $error .= '商品説明がありません。<br>';
    if (!$price) $error .= '価格がありません。<br>';
    if (preg_match('/\D/', $price)) $error .= '価格が不正です。<br>';
    if (!$stock) $error .= '在庫数がありません。<br>';
    if (!$error) {
        $dbh->query("UPDATE Product_Info SET Product_Name='$name', Product_Category='$category', Product_About='$comment',Product_Price=$price, Product_Stock=$stock WHERE Product_ID=$code");
        header('Location: index.php');
        exit();
    }
} else {
    $code = $_GET['code'];
    $st = $dbh->query("SELECT * FROM Product_Info WHERE Product_ID=$code");
    $row = $st->fetch();
    $name = $row['Product_Name'];
    $category = $row['Product_Category'];
    $comment = $row['Product_About'];
    $price = $row['Product_Price'];
    $stock = $row['Product_Stock'];
}
require 't_edit.php';
?>