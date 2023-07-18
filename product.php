<?php

require "pdo_connect.php";
session_start();
$productID = $_GET["name"];

$prepare = $dbh->prepare("SELECT * FROM Product_Info WHERE Product_ID = ?");
$prepare->execute([$productID]);
$result = $prepare->fetch(PDO::FETCH_ASSOC);

$prepare = $dbh->prepare("SELECT * FROM Product_Info WHERE Product_Category=?");
$prepare->execute([$result["Product_Category"]]);
$sameCategory = $prepare->fetchAll(PDO::FETCH_ASSOC);

$access = $result["Product_Access"];
$access ++;
$prepare = $dbh->prepare("UPDATE Product_Info SET Product_Access=? WHERE Product_ID=?");
$prepare->execute([$access,$productID]);

?>

<!DOCTYPE html>
<html>
<head>
	<title>商品詳細</title>
	<link href="js/slick-theme.css" rel="stylesheet" type="text/css">
	<link href="js/slick.css" rel="stylesheet" type="text/css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
	<script type="text/javascript" src="js/slick.min.js"></script>
	<script type="text/javascript" src="js/slide.js"></script>

	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/product.css">
</head>
<body>

	<?php require 'nav.php'; ?>

	<?php require 'search_area.php'; ?>

	<div class="container">

		<div class="image-area">
			<img src="img/<?php echo $result["Product_ID"] ?>.png" class="product-image">
		</div>

		<div class="about-area">
			<a href="search.php?c=<?php echo $result["Product_Category"] ?>" class="about-category">カテゴリ:<?php echo $result["Product_Category"] ?></a>
			<h2><?php echo $result["Product_Name"] ?></h2>
			<div class="about-price">\<?php echo $result["Product_Price"] ?>円</div>
			<div>商品説明</div>
			<div about-about><?php echo $result["Product_About"] ?></div>
		</div>

		<div class="cart-area">
			<div class="cart-price">\<?php echo $result["Product_Price"] ?>円</div>
			<?php if($result["Product_Stock"] > 0): ?>
				<div class="cart-stock">在庫あり</div>
			<?php else: ?>
				<div class="cart-stock">売り切れ</div>
			<?php endif; ?>
			<form action="cart.php?name=add" method="post" class="products">
				<label for="quantity">数量</label>
				<input type="number" min="0" max="<?php echo $result["Product_Stock"] ?>" name="quantity" value="0" class="cart-input">
        		<input type="hidden" name="code" value="<?php echo $result["Product_ID"] ?>">
        		<input type="submit" name="submit" value="カートに入れる" class="cart-submit">
			</form>
		</div>

    </div>

    <div class="slide-category">
				<h5><?php echo $result["Product_Category"] ?>の他の商品</h5>
				<ul class="slider">
				<?php for($i=0; $i<count($sameCategory); $i++): ?>
                    <li class="slide-content"><a href="product.php?name=<?php echo $sameCategory[$i]["Product_ID"] ?>">
                        <img src="img/<?php echo $sameCategory[$i]["Product_ID"] ?>.png" class="replace-image">
                        <div class="item"><?php echo $sameCategory[$i]["Product_Name"] ?></div>
                    </a></li>
                <?php endfor ?>
            	</ul>
	</div>

	<?php require 'footer.php'; ?>

    <script type="text/javascript" src="js/common.js"></script>

</body>
</html>