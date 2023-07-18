<?php

require "pdo_connect.php";
session_start();

$prepare = $dbh->prepare("SELECT * FROM Product_Info");
$prepare->execute();

$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

foreach($_SESSION["ROWS"] as $r){
    $stock = $result[$r['Product_ID'] - 1]["Product_Stock"];
    $stock -= $r['num'];
    $prepare = $dbh->prepare("UPDATE Product_Info SET Product_Stock = ? WHERE Product_ID = ?");
    $prepare->execute([$stock, $r['Product_ID']]);
}

$sum = 0;

for($i=0; count($_SESSION["ROWS"])>$i; $i++) {
    $sum += $_SESSION["ROWS"][$i]['Product_Price'] * $_SESSION["ROWS"][$i]['num'];
}

$table = "";
for($i=0; count($_SESSION["ROWS"])>$i; $i++) {
    $table .= '<tr><td class="name">'.$_SESSION["ROWS"][$i]["Product_Name"].'</td><td class="price">'.$_SESSION["ROWS"][$i]["Product_Price"].'</td></tr>';
}

?>

<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html" >
    <meta lang="ja">
    <meta charset="ISO-2022-JP">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style type="text/css">
      .container {
        width:50%;
        background:white;
        margin:0 auto;
        margin-top:20px;
        box-sizing:border-box;
        padding:30px;
        border-radius:8px;
        box-shadow: 0 0 8px rgba(0,0,0,0.3);
      }
      .list-header {
          width:100%;
          border-bottom:1px solid gray;
          font-size:24px;
          padding-left:10px;
      }
      .list-footer {
          width:100%;
          border-top:1px solid gray;
          font-size:24px;
          text-align:right;
          padding-top:5px;   
      }
      .total {
          font-weight:bold;
          padding-right:10px;
      }
      table {
          width:80%;
          margin:20px auto;
          font-size:20px;
      }

      .price {
          font-weight:bold;
          text-align:right;
      }
    </style>
    </head>
    <body>
        <div class="container">

          <h2><?php echo $_SESSION['USER'] ?> 様</h2>
          <p>ご購入いただきありがとうございます。</p>
          <div class="list-header">
              注文内容
          </div>
          <table>
              <?php echo $table ?>
          </table>
          <div class="list-footer">
              合計金額 <span class="total">\<?php echo $sum ?></span>
          </div>
          <p>注文日: <?php echo date("Y/m/d") ?></p>
          <p>またのご利用をお待ちしております。</p>
          <p><a href="#">ECサイト</a></p>

        </div>
    </body> 
</html>