<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>商品一覧</title>
<link rel="stylesheet" href="kanri.css">
</head>
<body>
<table>
  <?php foreach ($goods as $g) { ?>
    <tr>
      <td>
        <img src="../img/<?php echo $g["Product_ID"] ?>.png" class="product-image" class="product-image">
      </td>
      <td>
        <p class="goods"><?php echo $g['Product_Name'] ?></p>
        <p><?php echo nl2br($g['Product_About']) ?></p>
      </td>
      <td width="80">
        <p><?php echo $g['Product_Price'] ?> 円</p>
        <p><a href="edit.php?code=<?php echo $g['Product_ID'] ?>">修正</a></p>
        <p><a href="upload.php?code=<?php echo $g['Product_ID'] ?>">画像</a></p>
        <p><a href="delete.php?code=<?php echo $g['Product_ID'] ?>" onclick="return confirm('削除してよろしいですか？')">削除</a></p>
      </td>
    </tr>
  <?php } ?>
</table>
<div class="base">
  <a href="insert.php">新規追加</a>　
  <a href="../index.php" target="_blank">サイト確認</a>
</div>
</body>
</html>