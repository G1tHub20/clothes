<?php
  require_once('process.php');

  // 件数取得
  $stmt = $dbh->query("SELECT COUNT(*) FROM clothes_items2");
  $count = $stmt->fetch();
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
<a href="admin.php" class="right">管理者画面</a>

<h3>条件を指定して検索してください</h3>
<form action="" method="post" name="form1">
  <div class="function">
    <div class="material">
    <p>素材種類</p>
    <select name="material" onChange="unlockRate()">
        <option value=""<?php if($input_material == "") { echo 'selected'; } ?>>すべて</option>
        <?php foreach($all_material as $material): ?>
          <option value="<?php echo $material ?>"<?php if($input_material == $material) { echo 'selected'; } ?>><?php echo $material ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="rate">
        <p>混率</p>
        <select name="rate" disabled required>
          <option value=""<?php if($input_rate == "") { echo 'selected'; } ?>>指定してください</option>
          <?php foreach($all_rate as $rate): ?>
          <option value="<?php echo $rate ?>"<?php if($input_rate == $rate) { echo 'selected'; } ?>><?php echo $rate ?>%以上</option>
        <?php endforeach; ?>
      </select>
    </div>    
    <div class="feature">
      <p>機能・加工</p>
      <?php foreach($all_feature as $feature): ?>
      <input type="radio" name="feature" value="<?php echo $feature ?>"<?php if($input_feature == $feature) { echo 'checked'; } ?>><?php echo $feature ?>
    <?php endforeach; ?>
  </div>
  <div class="freeword">
    <p>フリーワード</p>
    概要欄から検索：<input type="text" name="freeword" placeholder="(例)サスティナブル" value="<?php if(!empty($input_freeword)) { echo $input_freeword; } ?>">
  </div>
  <br>
  <div>
  <button type="submit">検索</button> <button type="button" onclick="location.href=''">リセット</button>
</div>
</form>

<table>
<tr><?php if ($_SERVER['REQUEST_METHOD'] === 'POST') echo $num_of_hits ?>件ヒット（全<?php echo $count[0] ?>件）</tr>
<tr><th>商品コード</th><th>メーカー</th><th>概要</th><th>価格</th></tr>
<?php foreach ($items as $row): ?>
  <tr><td><?php echo($row[1]) ?></td><td><?php echo($row[2]) ?></td><td><?php echo($row[8]) ?></td><td>￥<?php echo($row[9]) ?></td></tr>
<?php endforeach; ?>
</table>

<script>
// 素材種類の指定に応じて、混率を指定可能にする
const form1 = document.forms.form1;
const input_material = form1.material.value;
if (input_material !== "") {
  form1.rate.disabled = false;
}
function unlockRate() {
  const form1 = document.forms.form1;
  const input_material = form1.material.value;

  console.log(input_material);//

  if (input_material !== "") {
    form1.rate.disabled = false;
  } else {
    form1.rate.disabled = true;
  }
}
</script>

</body>
</html>