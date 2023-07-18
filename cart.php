<?php

require "pdo_connect.php";

session_start();

$sum = 0;

$_SESSION["ROWS"] = array();
if (!isset($_SESSION['CART'])) $_SESSION['CART'] = array();
if (@$_POST['submit']) {
    @$_SESSION['CART'][$_POST['code']] += $_POST['quantity'];
}

foreach($_SESSION['CART'] as $code => $num) {
    $st = $dbh->prepare("SELECT * FROM Product_Info WHERE Product_ID=?");
    $st->execute(array($code));
    $row = $st->fetch();
    $st->closeCursor();
    $row['num'] = strip_tags($num);
    $_SESSION["ROWS"][] = $row;
}

if(@$_GET["name"]){
    header('Location: product_list.php?name=added');
}

for($i=0; count($_SESSION["ROWS"])>$i; $i++) {
    $sum += $_SESSION["ROWS"][$i]['Product_Price'] * $_SESSION["ROWS"][$i]['num'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>カート</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <?php require 'nav.php'; ?>
    <?php require 'search_area.php'; ?>

    <div class="container">

		<div class="left-content">
			<div class="cart-content">
				<h3>ショッピングカート</h3>
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
						<div>
    						<a href="cart_delete.php?code=<?php echo $_SESSION["ROWS"][$i]['Product_ID'] ?>" class="cart-delete">
    							削除する
    						</a>
						</div>
					</div>
					<div class="cart-content-price">
						\<?php echo $_SESSION["ROWS"][$i]['Product_Price'] * $_SESSION["ROWS"][$i]['num'] ?>
					</div>
				</div>
				<?php endfor ?>
				<div class="cart-item cart-item-footer">
					<div class="cart-empty">
						<a href="cart_empty.php">カートを空にする</a>
					</div>
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
				<a href="buy.php" class="cart-sumbit-button">レジに進む</a>
			</div>
		</div>

    </div>

    <?php if(@$_GET["state"] == "noitem"): ?>
        <div class="popup">
    		カートに商品がありません
        </div>
    <?php endif ?>

    <?php require 'footer.php'; ?>

    <script src="js/popup.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
</body>
</html>