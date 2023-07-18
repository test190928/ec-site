<?php

require "pdo_connect.php";

session_start();

$prepare = $dbh->prepare("SELECT * FROM Product_Info LIMIT 10");
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

$prepare = $dbh->prepare("SELECT * FROM Product_Info ORDER BY Product_Access DESC LIMIT 8");
$prepare->execute();
$pickup = $prepare->fetchAll(PDO::FETCH_ASSOC);

$prepare = $dbh->prepare("SELECT * FROM Product_Info WHERE Product_Category='食品'");
$prepare->execute();
$food = $prepare->fetchAll(PDO::FETCH_ASSOC);

$prepare = $dbh->prepare("SELECT * FROM Product_Info WHERE Product_Category='文房具'");
$prepare->execute();
$stationery = $prepare->fetchAll(PDO::FETCH_ASSOC);

$prepare = $dbh->prepare("SELECT Product_Category FROM Product_Info GROUP BY Product_Category");
$prepare->execute();
$category = $prepare->fetchAll(PDO::FETCH_ASSOC);

$prepare = $dbh->prepare("SELECT Product_Category,SUM(Product_Access) FROM Product_Info GROUP BY Product_Category ORDER BY SUM(Product_Access) DESC");
$prepare->execute();
$pickupCategory = $prepare->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>商品一覧</title>
	<meta charset="UTF-8">
	<link href="js/slick-theme.css" rel="stylesheet" type="text/css">
	<link href="js/slick.css" rel="stylesheet" type="text/css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
	<script type="text/javascript" src="js/slick.min.js"></script>
	<script type="text/javascript" src="js/slide.js"></script>

	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/popup.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<?php require 'nav.php'; ?>

	<?php require 'search_area.php'; ?>


	<div class="header">
		<ul class="header-slider">
			<li><a href="#">sample</a></li>
			<li><a href="#">sample</a></li>
			<li><a href="#">sample</a></li>
			<li><a href="#">sample</a></li>
		</ul>
	</div>

	<div class="container">

		<div class="left-content">
			<div class="left-width">

			<div class="slide-category">
				<h5>食品の商品</h5>
				<ul class="slider">
				<?php for($i=0; $i<count($food); $i++): ?>
                    <li class="slide-content"><a href="product.php?name=<?php echo $food[$i]["Product_ID"] ?>">
                        <img src="img/<?php echo $food[$i]["Product_ID"] ?>.png" class="replace-image">
                        <div class="item"><?php echo $food[$i]["Product_Name"] ?></div>
                    </a></li>
                <?php endfor ?>
            	</ul>
			</div>

			<div class="slide-category">
				<h5>文房具の商品</h5>
				<ul class="slider">
				<?php for($i=0; $i<count($stationery); $i++): ?>
                    <li class="slide-content"><a href="product.php?name=<?php echo $stationery[$i]["Product_ID"] ?>">
                        <img src="img/<?php echo $stationery[$i]["Product_ID"] ?>.png" class="replace-image">
                        <div class="item"><?php echo $stationery[$i]["Product_Name"] ?></div>
                    </a></li>
                <?php endfor ?>
            	</ul>
			</div>

    		<?php for($i=0; $i<count($result); $i++): ?>
            	<form action="cart.php?name=add" method="post" class="products">
        			<div class="product">
        				<a href="product.php?name=<?php echo $result[$i]["Product_ID"] ?>"><img src="<?php echo $result[$i]["Product_Image"] ?>" class="product-image"></a>
        				<h3><a href="product.php?name=<?php echo $result[$i]["Product_ID"] ?>" class="item-name"><?php echo $result[$i]["Product_Name"] ?></a></h3>
        				<div><?php echo $result[$i]["Product_Price"] ?>円</div>
        				<div>数量</div>
        				<input type="number" min="0" max="<?php echo $result[$i]["Product_Stock"] ?>" name="quantity">
        				<input type="hidden" name="code" value="<?php echo $result[$i]["Product_ID"] ?>">
        				<input type="submit" name="submit" value="カートに入れる">
        				<div>在庫数:<?php echo $result[$i]["Product_Stock"] ?>個</div>
        			</div>
        		</form>
        	<?php endfor ?>
        	</div>
        </div>

        <div class="right-content">
			<div class=pickup-category>
				<h5>おすすめのカテゴリ</h5>
				<ul>
					<?php for($i=0; $i<count($pickupCategory); $i++): ?>
    					<li><a href="search.php?c=<?php echo $pickupCategory[$i]["Product_Category"] ?>"><?php echo $pickupCategory[$i]["Product_Category"] ?></a></li>
    				<?php endfor; ?>
				</ul>
			</div>
			<div class="pickup-product">
				<h5>人気の商品</h5>
				<?php for($i=0; $i<count($pickup); $i++): ?>
					<div class="pickup">
						<a href="product.php?name=<?php echo $pickup[$i]["Product_ID"] ?>">
						<img src="<?php echo $pickup[$i]["Product_Image"] ?>" class="pickup-image">
						<a href=""><?php echo $pickup[$i]["Product_Name"] ?></a>
						<div class="pickup-price"><?php echo $pickup[$i]["Product_Price"] ?>円</div>
						</a>
					</div>
				<?php endfor ?>
			</div>
        </div>

    </div>

	<?php if(@$_GET["name"] == "added"): ?>
        <div class="popup">
    		カートに商品を追加しました
    		<a href="cart.php" class="go-cart">カートを見る</a>
        </div>
    <?php endif ?>

    <?php require 'footer.php'; ?>

    <script src="js/popup.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</body>
</html>