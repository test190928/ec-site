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
		<div class="user">
			<?php if(isset($_SESSION['USER'])): ?>
				<a class="user-name">
					<?php echo $_SESSION['USER'] ?>
				</a>
			<?php else: ?>
				<a href="index.php" class="user-name">ログイン</a>
			<?php endif; ?>
		</div>
</div>