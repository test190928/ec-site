<?php

require "pdo_connect.php";
session_start();

if(empty($_SESSION["CART"])){
    header("Location:cart.php?state=noitem");
}

$sum = 0;

for($i=0; count($_SESSION["ROWS"])>$i; $i++) {
    $sum += $_SESSION["ROWS"][$i]['Product_Price'] * $_SESSION["ROWS"][$i]['num'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>購入確認</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
	<?php require "nav.php"; ?>

	<?php require 'search_area.php'; ?>

    <div class="container">

		<div class="left-content">
			<div class="cart-content">
				<h3>購入確認</h3>
				<?php for($i=0; count($_SESSION["ROWS"])>$i; $i++): ?>
				<div class="cart-item">
					<div class="cart-content-image">
						<img src="img/<?php echo $_SESSION["ROWS"][$i]['Product_ID'] ?>.png">
					</div>
					<div class="cart-content-about">
						<a href=""><?php echo $_SESSION["ROWS"][$i]['Product_Name'] ?></a>
						<div class="unit-price">
							<small>単価:\<?php echo $_SESSION["ROWS"][$i]['Product_Price'] ?></small>
						</div>
						<div>
							<?php if($_SESSION["ROWS"][$i]["Product_Stock"] > 0): ?>
                				<div class="cart-stock">在庫あり</div>
                			<?php else: ?>
                				<div class="cart-stock">売り切れ</div>
                			<?php endif; ?>
						</div>
					</div>
					<div class="cart-content-quantity">
						<div>数量:<?php echo $_SESSION["ROWS"][$i]['num'] ?>点</div>
					</div>
					<div class="cart-content-price">
						\<?php echo $_SESSION["ROWS"][$i]['Product_Price'] * $_SESSION["ROWS"][$i]['num'] ?>
					</div>
				</div>
				<?php endfor ?>
				<div class="cart-item cart-item-footer">
					<div class="cart-content-total-price">
						合計金額:\<?php echo $sum ?>
					</div>
				</div>
			</div>
		</div>
		<div class="right-content">
			<div class="cart-submit">
				<div class="subtotal">小計(税込):</div>
				<div class="cart-total">\<?php echo $sum ?></div>
				<div class="clear"></div>
				<div class="subtotal">配達料:</div>
				<div class="cart-total">\0</div>
				<div class="clear"></div>
				<div class="cart-border"></div>
				<div class="total">合計金額:</div>
				<div class="total-num">\<?php echo $sum ?></div>
				<div class="clear"></div>
				<a href="buy_complete.php" class="cart-sumbit-button">購入を確定する</a>
			</div>
		</div>

    </div>

    <?php require "footer.php"; ?>
    <script src="js/common.js"></script>
</body>
</html>