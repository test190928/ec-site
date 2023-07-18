<link rel="stylesheet" href="css/nav.css">

<div class="nav">
		<a href="product_list.php" class="logo">
			ECサイト
		</a>
		<a href="cart.php" class="cart">
			カート
			<span class="cart-quantity">
				<?php echo @count($_SESSION['CART']); ?>
			</span>
		</a>
		<ul class="gnav">
			<li>
				<?php if(isset($_SESSION['USER'])): ?>
    				<a>
    					<?php echo $_SESSION['USER'] ?>
    				</a>
    			<?php else: ?>
    				<a href="index.php">ログイン</a>
    			<?php endif; ?>
    			<?php if(@isset($_SESSION["ID"])): ?>
				<ul>
					<li><a href="account.php">アカウント</a></li>
					<?php if(@$_SESSION["RIGHT"] == "admin"): ?>
						<li><a href="admin/index.php">管理者ページ</a></li>
					<?php endif; ?>
					<li><a href="logout.php">ログアウト</a></li>
				</ul>
				<?php endif; ?>
			</li>
		</ul>

</div>