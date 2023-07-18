<?php

$prepare = $dbh->prepare("SELECT Product_Category FROM Product_Info GROUP BY Product_Category");
$prepare->execute();
$category = $prepare->fetchAll(PDO::FETCH_ASSOC);

?>

	<link rel="stylesheet" href="css/search.css">

	<div class="search-area">
    		<form action="search.php" method="get" class="form-search">
    			<select name="category" class="category-select">
    				<option value="">カテゴリ</option>
    				<?php for($i=0; $i<count($category); $i++): ?>
    					<option value="<?php echo $category[$i]["Product_Category"] ?>"><?php echo $category[$i]["Product_Category"] ?></option>
    				<?php endfor; ?>
    			</select>
        		<input type="text" class="search" name="search">
        		<input type="submit" value="検索" class="search-submit"><br>
        	</form>
	</div>