<?php

session_start();

unset($_SESSION["CART"][$_GET["code"]]);
header("Location: cart.php");

?>
<a href="cart.php">
戻る
</a>