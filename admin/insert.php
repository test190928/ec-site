<?php

require "../pdo_connect.php";
$error = $name = $comment = $price = $category = $stock = '';
if (@$_POST['submit']) {
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
        $dbh->query("INSERT INTO Product_Info(Product_Name,Product_Category,Product_About,Product_Price,Product_Stock) VALUES('$name','$category','$comment','$price','$stock')");
        header('Location: index.php');
        exit();
    }
}
require 't_insert.php';

?>