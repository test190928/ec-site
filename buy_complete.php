<?php

require "pdo_connect.php";
session_start();

$prepare = $dbh->prepare("SELECT * FROM Product_Info");
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

$prepare = $dbh->prepare("SELECT * FROM User_Info WHERE User_ID = ?");
$prepare->execute([$_SESSION["ID"]]);
$user = $prepare->fetchAll(PDO::FETCH_ASSOC);

foreach($_SESSION["ROWS"] as $r){
    $stock = $result[$r['Product_ID'] - 1]["Product_Stock"];
    $stock -= $r['num'];
    $prepare = $dbh->prepare("UPDATE Product_Info SET Product_Stock = ? WHERE Product_ID = ?");
    $prepare->execute([$stock, $r['Product_ID']]);
}


// $_SESSION["CART"] = null;
$date = date("Y/m/d");

$sum = 0;

for($i=0; count($_SESSION["ROWS"])>$i; $i++) {
    $sum += $_SESSION["ROWS"][$i]['Product_Price'] * $_SESSION["ROWS"][$i]['num'];
}

$table = "";
for($i=0; count($_SESSION["ROWS"])>$i; $i++) {
    $table .= '<tr><td class="name">'.$_SESSION["ROWS"][$i]["Product_Name"].'</td><td class="price">&yen;'.$_SESSION["ROWS"][$i]["Product_Price"].'</td></tr>';
}

?>

<?php
    mb_language("japanese"); //日本語に設定。
    mb_internal_encoding("UTF-8"); //UTF-8に設定。

    $from = "sample202012@gmail.com"; //送信元
    $to = $user[0]["Email_Address"]; //宛先
    $subject = "ご注文確定のお知らせ"; //件名

    $today = date("Y/m/d"); //今日の日付を取得

    $html_body = <<<EOM
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
        border:1px solid gray;
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

          <h2>{$_SESSION["USER"]} 様</h2>
          <p>ご購入いただきありがとうございます。</p>
          <div class="list-header">
              注文内容
          </div>
          <table>
              {$table}
          </table>
          <div class="list-footer">
              合計金額 <span class="total"> &yen;{$sum}</span>
          </div>
          <p>注文日: {$date}</p>
          <p>またのご利用をお待ちしております。</p>
          <p><a href="#">ECサイト</a></p>
        </div>
    </body> 
    </html>
    EOM; //ヒアドキュメントの終了

    $headers = '';
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-Type: text/html; charset=iso-2022-jp' . "\r\n";
    $headers .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n";
    $headers .= "From: " . $from . "\r\n";

    $subject = mb_convert_encoding($subject, "iso-2022-jp"); //件名をJISに変換

    $message = '';
    $message .= quoted_printable_encode(mb_convert_encoding($html_body, 'iso-2022-jp', 'UTF-8')) . "\r\n"; //HTMLメールの本文をJISに変換したのちにquoted-printableに変換

    @mb_send_mail($to, $subject, $message, $headers);

    $_SESSION["CART"] = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>購入完了</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/buy_complete.css">
</head>
<body>
	<?php require "nav.php"; ?>
	<?php require 'search_area.php'; ?>

	<div class="container">
    	<h1>購入ありがとうございました</h1>
    	<div>
    		<a href="product_list.php">トップに戻る</a>
    	</div>
    </div>

	<?php require "footer.php"; ?>
	<script src="js/common.js"></script>
</body>
</html>