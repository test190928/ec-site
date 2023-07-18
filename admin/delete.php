<?php
require 'admin.php';
require "../pdo_connect.php";
$st = $dbh->query("DELETE FROM Product_Info WHERE Product_ID = {$_GET["code"]}");
header("Location: index.php");

?>