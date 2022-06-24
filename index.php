<?php
  require_once('process.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css"/>
  <title>商品検索</title>
</head>
<body>
<h3>条件を指定して検索してください</h3>
<!-- <form action="/clothes/result.php" method="post"> -->
<form action="" method="post">
  <div class="category">
  <p>カテゴリー</p>
  <select name="category">
  <option value=""<?php if($input_category == "") { echo 'selected'; } ?>>すべてのカテゴリー</option>
  <option value="コート"<?php if($input_category == $all_category[0]) { echo 'selected'; } ?>>コート</option>
  <option value="ジャケット"<?php if($input_category == $all_category[1]) { echo 'selected'; } ?>>ジャケット</option>
  <option value="ポロシャツ"<?php if($input_category == $all_category[2]) { echo 'selected'; } ?>>ポロシャツ</option>
  <option value="Tシャツ"<?php if($input_category == $all_category[3]) { echo 'selected'; } ?>>Tシャツ</option>
</select>

  </div>
  <div class="user">
  <p>ターゲット</p>
  <input type="checkbox" name="user[]" value="メンズ"<?php if(!empty(in_array($all_user[0], $input_user, true))) { echo 'checked'; } ?>>メンズ
  <input type="checkbox" name="user[]" value="レディース"<?php if(!empty(in_array($all_user[1], $input_user, true))) { echo 'checked'; } ?>>レディース
  <input type="checkbox" name="user[]" value="男女共用"<?php if(!empty(in_array($all_user[2], $input_user, true))) { echo 'checked'; } ?>>男女共用
  <input type="checkbox" name="user[]" value="キッズ"<?php if(!empty(in_array($all_user[3], $input_user, true))) { echo 'checked'; } ?>>キッズ
  </div>
  <div class="color">
  <p>色</p>
  <input type="checkbox" name="color[]" value="黒"<?php if(!empty(in_array($all_color[0], $input_color, true))) { echo 'checked'; } ?>>黒 <!-- 複数件取得するため、name属性を配列にする -->
  <input type="checkbox" name="color[]" value="黄"<?php if(!empty(in_array($all_color[1], $input_color, true))) { echo 'checked'; } ?>>黄
  <input type="checkbox" name="color[]" value="青"<?php if(!empty(in_array($all_color[2], $input_color, true))) { echo 'checked'; } ?>>青
  <input type="checkbox" name="color[]" value="赤"<?php if(!empty(in_array($all_color[3], $input_color, true))) { echo 'checked'; } ?>>赤
  <input type="checkbox" name="color[]" value="紫"<?php if(!empty(in_array($all_color[4], $input_color, true))) { echo 'checked'; } ?>>紫
  <input type="checkbox" name="color[]" value="白"<?php if(!empty(in_array($all_color[5], $input_color, true))) { echo 'checked'; } ?>>白
  <input type="checkbox" name="color[]" value="ピンク"<?php if(!empty(in_array($all_color[6], $input_color, true))) { echo 'checked'; } ?>>ピンク
  <input type="checkbox" name="color[]" value="グレー"<?php if(!empty(in_array($all_color[7], $input_color, true))) { echo 'checked'; } ?>>グレー
  </div>
  <div class="size">
  <p>サイズ</p>
  <input type="checkbox" name="size[]" value="SS"<?php if(!empty(in_array($all_size[0], $input_size, true))) { echo 'checked'; } ?>>SS
  <input type="checkbox" name="size[]" value="S"<?php if(!empty(in_array($all_size[1], $input_size, true))) { echo 'checked'; } ?>>S
  <input type="checkbox" name="size[]" value="M"<?php if(!empty(in_array($all_size[2], $input_size, true))) { echo 'checked'; } ?>>M
  <input type="checkbox" name="size[]" value="L"<?php if(!empty(in_array($all_size[3], $input_size, true))) { echo 'checked'; } ?>>L
  <input type="checkbox" name="size[]" value="LL"<?php if(!empty(in_array($all_size[4], $input_size, true))) { echo 'checked'; } ?>>LL
  <input type="checkbox" name="size[]" value="3L"<?php if(!empty(in_array($all_size[5], $input_size, true))) { echo 'checked'; } ?>>3L
  <input type="checkbox" name="size[]" value="フリー"<?php if(!empty(in_array($all_size[6], $input_size, true))) { echo 'checked'; } ?>>フリー
  </div>
  <div class="company">
  <p>メーカー</p>
  <input type="checkbox" name="company[]" value="A社"<?php if(!empty(in_array($all_company[0], $input_company, true))) { echo 'checked'; } ?>>A社
  <input type="checkbox" name="company[]" value="B社"<?php if(!empty(in_array($all_company[1], $input_company, true))) { echo 'checked'; } ?>>B社
  <input type="checkbox" name="company[]" value="C社"<?php if(!empty(in_array($all_company[2], $input_company, true))) { echo 'checked'; } ?>>C社
  <input type="checkbox" name="company[]" value="D社"<?php if(!empty(in_array($all_company[3], $input_company, true))) { echo 'checked'; } ?>>D社
  <input type="checkbox" name="company[]" value="E社"<?php if(!empty(in_array($all_company[4], $input_company, true))) { echo 'checked'; } ?>>E社
  </div>
  <div class="price">
  <p>価格</p>
  <input type="radio" name="price" value="0"<?php if($input_price == "0") { echo 'checked'; } ?>>指定なし
  <input type="radio" name="price" value="1"<?php if($input_price == "1") { echo 'checked'; } ?>>0-1499円
  <input type="radio" name="price" value="2"<?php if($input_price == "2") { echo 'checked'; } ?>>1500-2999円
  <input type="radio" name="price" value="3"<?php if($input_price == "3") { echo 'checked'; } ?>>3000-5999円
  <input type="radio" name="price" value="4"<?php if($input_price == "4") { echo 'checked'; } ?>>6000-9999円
  <input type="radio" name="price" value="5"<?php if($input_price == "5") { echo 'checked'; } ?>>10000円以上
  </div>
  <br>
  <div>
  <button type="submit">検索</button> <button type="button" onclick="location.href=''">指定解除</button>
</div>
</form>

<table>
<tr><?php if ($_SERVER['REQUEST_METHOD'] === 'POST') echo $num_of_hits ?>件ヒット（全100件）</tr>
<tr><th>商品コード</th><th>カテゴリー</th><th>ターゲット</th><th>色</th><th>サイズ</th><th>メーカー</th><th>価格</th></tr>
<?php foreach ($res as $row): ?>
  <tr><td><?php echo($row[1]) ?></td><td><?php echo($row[2]) ?></td><td><?php echo($row[3]) ?></td><td><?php echo($row[4]) ?></td><td><?php echo($row[5]) ?></td><td><?php echo($row[6]) ?></td><td><?php echo('￥'. $row[7]) ?></td></tr>
<?php endforeach; ?>
</table>

</body>
</html>