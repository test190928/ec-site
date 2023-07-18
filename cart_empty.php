<?php

require "pdo_connect.php";
session_start();

$_SESSION["CART"] = null;
header('Location: cart.php');

?>