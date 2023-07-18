<?php

require "pdo_connect.php";
session_start();

if(empty($_GET["search"]) && empty($_GET["category"])){
    $prepare = $dbh->prepare("SELECT * FROM Product_Info");
}else if(empty($_GET["search"])){
    $prepare = $dbh->prepare("SELECT * FROM Product_Info WHERE Product_Category LIKE '%".$_GET["category"]."%'");
}else if(empty($_GET["category"])){
    $prepare = $dbh->prepare("SELECT * FROM Product_Info WHERE Product_Name LIKE '%".$_GET["search"]."%'");
}else {
    $prepare = $dbh->prepare("SELECT * FROM Product_Info WHERE Product_Name LIKE '%".$_GET["search"]."%' AND Product_Category LIKE '%".$_GET["category"]."%' ");
}

$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

$prepare = $dbh->prepare("SELECT * FROM Product_Info LIMIT 8");
$prepare->execute();
$pickup = $prepare->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>商品一覧</title>
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/search.css">
</head>
<body>
	<?php require 'nav.php'; ?>

	<?php require 'search_area.php'; ?>

	<div class="container">

		<div class="left-content">
			<div class="search-word">
				<p>
					カテゴリ:
					<?php if(!empty($_GET["category"])){
					    echo $_GET["category"];
					}else{
					    echo "なし";
					}
					?>
				</p>
				<p>
					キーワード:
					<?php if(!empty($_GET["search"])){
					    echo $_GET["search"];
					}else{
					    echo "なし";
					}
					?>
				</p>
			</div>
			<h3>検索結果:<?php echo count($result) ?>件</h3>
    		<div class="search-result">
    			<?php for($i=0; $i<count($result); $i++): ?>
    			<div class="search-result-item">
    				<a href="product.php?name=<?php echo $result[$i]["Product_ID"] ?>">
    					<img src="<?php echo $result[$i]["Product_Image"] ?>" class="search-result-image">
    				</a>
    				<a href="product.php?name=<?php echo $result[$i]["Product_ID"] ?>"><?php echo $result[$i]["Product_Name"] ?></a>
    				<div>\<?php echo $result[$i]["Product_Price"] ?></div>
    				<?php if($result[$i]["Product_Stock"] > 0): ?>
    					<small>在庫あり</small>
    				<?php else: ?>
    					<small>在庫なし</small>
    				<?php endif ?>
    			</div>
    			<?php endfor ?>
    		</div>
		</div>
		<div class="right-content">
			<div class=pickup-category>
				<h5>おすすめのカテゴリ</h5>
				<ul>
					<?php for($i=0; $i<count($category); $i++): ?>
    					<li><a href="search.php?c=<?php echo $category[$i]["Product_Category"] ?>"><?php echo $category[$i]["Product_Category"] ?></a></li>
    				<?php endfor; ?>
				</ul>
			</div>
			<div class="pickup-product">
				<h5>おすすめの商品</h5>
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


    <?php require 'footer.php'; ?>

    <script type="text/javascript" src="js/common.js"></script>

</body>
</html>