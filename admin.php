<?php
require_once('library.php');
session_start();

$sql = "SELECT * FROM clothes_items2"; //追加・変更等の実行後、それぞれ一覧に反映するために全件取得するので、関数にまとめたいがうまくいかない…
$stmt = $dbh->query($sql);
$allItems = $stmt->fetchAll();


$message = "";
// echo $message;
if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
}
$convertibleButton = "<button type='submit' name='confirmInsert' onClick=\"return confirmExecution('追加')\">追加する</button>";
$backButton = "";
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style2.css"/>
  <title>管理者画面</title>
</head>
<body>
<a href="index.php" class="right">商品検索</a>

<?php
// 一覧の更新ボタンを押したら
if (isset($_POST['update'])) {
  $id = $_POST['update'];
  // echo($id . "<br>");
  $code = $_POST['code'];
  $_SESSION = array(); //即データを削除したい場合、明示的にデータを空にする必要がある
  session_destroy();
  $message = "";
  
  $convertibleButton = "<button type='submit' name='confirmUpdate' value='{$id}' onClick=\"return confirmExecution('更新')\">更新する</button>";
  //$backButton = "<button type='button' name='back' onclick=\"location.href='admin.php'\">戻る</button>"; //formタグ内でリンク先に飛ぶには、「type="button"」にする必要がある
  $backButton = "<button type='submit' name='back'>戻る</button>";
}

// 一覧の削除ボタンを押したら
if (isset($_POST['delete'])) {
  $id = $_POST['delete'];
  // echo($id . "<br>");
  $code = $_POST['code'];
  $_SESSION = array(); //即データを削除したい場合、明示的にデータを空にする必要がある
  session_destroy();
  $message = "";
  // $convertibleButton = "<button type='submit' name='confirmDelete' value='{$id}' onClick=\"return confirmExecution('delete', this.value)\">削除する</button>"; //valueの値を引数で渡せる
  $convertibleButton = "<button type='submit' name='confirmDelete' value='{$id}' onClick=\"return confirmExecution('削除')\">削除する</button>";
  $backButton = "<button type='submit' name='back'>戻る</button>";
}

// ============================== 戻るボタン ==============================
if (isset($_POST['back'])) {
  // echo "戻るボタンが押された<br>";
  $_POST = array();
  $_SESSION = array();
  session_destroy();
  $message = "";

  // header('Location:http://localhost/clothes/second/admin.php');
  // exit();
}

// ============================== 追加実行 ==============================
if (isset($_POST['confirmInsert'])) {
  // echo "追加実行ボタンが押された". "<br>";

  $params[] = $_POST['code'];
  $params[] = $_POST['company'];
  $params[] = $_POST['material_1'];
  $params[] = $_POST['rate_1'];
  $params[] = $_POST['material_2'];
  $params[] = $_POST['rate_2'];
  $params[] = $_POST['feature'];
  $params[] = $_POST['summary'];
  $params[] = $_POST['price'];

  // $sql = "INSERT INTO items2 (material_1, rate_1, material_2, rate_2, feature, summary, price) VALUES (:material_1, :rate_1, :material_2, :rate_2, :feature, :summary, :price)";
  $sql = "INSERT INTO clothes_items2 (code, company, material_1, rate_1, material_2, rate_2, feature, summary, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  echo $sql . "<br>";
  $stmt = $dbh->prepare($sql);
  $result = $stmt->execute($params);
  if ($result == true) {
    $code = $_POST['code'];
    $_POST = array();
    $message = "新商品を追加しました。";
  } else {
    $message = "追加処理が失敗しました。";
  }
  $_SESSION['message'] = $message;

  //一覧に反映
  $sql = "SELECT * FROM clothes_items2";
  $stmt = $dbh->query($sql);
  $allItems = $stmt->fetchAll();
  // header('Location: http://localhost/clothes/second/admin.php'); //header関数によるページ遷移は要注意！ それ以前の出力の有無など
  // exit();
}

// ============================== 更新実行 ==============================
if (isset($_POST['confirmUpdate'])) {
  $id = $_POST['confirmUpdate'];
  // echo "更新実行ボタンが押された：". $id. "<br>";

  $params[] = $_POST['code'];
  $params[] = $_POST['company'];
  $params[] = $_POST['material_1'];
  $params[] = $_POST['rate_1'];
  $params[] = $_POST['material_2'];
  $params[] = $_POST['rate_2'];
  $params[] = $_POST['feature'];
  $params[] = $_POST['summary'];
  $params[] = $_POST['price'];

  $sql = "UPDATE clothes_items2 SET code=?, company=?, material_1=?, rate_1=?, material_2=?, rate_2=?, feature=?, summary=?, price=? WHERE id = {$id}";
  // echo $sql . "<br>";
  $stmt = $dbh->prepare($sql);
  $result = $stmt->execute($params);
  if ($result == true) {
    $code = $_POST['code'];
    $_POST = array();
    $message = "商品コード:" . $code . "を更新しました。";
  } else {
    $message = "更新処理が失敗しました。";
  }
  $_SESSION['message'] = $message;
  //一覧に反映
  $sql = "SELECT * FROM clothes_items2";
  $stmt = $dbh->query($sql);
  $allItems = $stmt->fetchAll();
}

// ============================== 削除実行 ==============================
if (isset($_POST['confirmDelete'])) {
  $id = $_POST['confirmDelete'];
  // echo "削除実行ボタンが押された：". $id. "<br>";
  
  $sql = "DELETE FROM clothes_items2 WHERE id = ?";
  // echo $sql . "<br>";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $result = $stmt->execute();
  if ($result == true) {
    $code = $_POST['code'];
    $_POST = array();
    $message = "商品コード:" . $code . "を削除しました。";
  } else {
    $message = "削除処理が失敗しました。";
  }
  $_SESSION['message'] = $message;
  //一覧に反映
  $sql = "SELECT * FROM clothes_items2";
  $stmt = $dbh->query($sql);
  $allItems = $stmt->fetchAll();
}

?>


<h3>管理者によるデータの登録・変更ができます</h3>
<form action="" method="POST">
<table id="form_table">
  <tr><th>商品コード</th><th>メーカー</th><th>素材種類_1</th><th>混率_1</th><th>素材種類_2</th><th>混率_2</th><th>機能・加工</th><th>概要</th><th>価格</th></tr>
  <tr>
    <td><input type="text" name="code" value="<?php if(isset($_POST['code'])) echo($_POST['code']) ?>" placeholder="AAX-9999" required></td>
    <td><input type="text" name="company" value="<?php if(isset($_POST['company'])) echo($_POST['company']) ?>" placeholder="X社" required></td>
    <td><input type="text" name="material_1" value="<?php if(isset($_POST['material_1'])) echo($_POST['material_1']) ?>" required></td>
    <td><input type="text" name="rate_1" value="<?php if(isset($_POST['rate_1'])) echo($_POST['rate_1']) ?>" placeholder="※数字" required></td>
    <td><input type="text" name="material_2" value="<?php if(isset($_POST['material_2'])) echo($_POST['material_2']) ?>" required></td>
    <td><input type="text" name="rate_2" value="<?php if(isset($_POST['rate_2'])) echo($_POST['rate_2']) ?>" placeholder="※数字" required></td>
    <td><input type="text" name="feature" value="<?php if(isset($_POST['feature'])) echo($_POST['feature']) ?>" required></td>
    <td><input type="text" name="summary" value="<?php if(isset($_POST['summary'])) echo($_POST['summary']) ?>" required></td>
    <td><input type="text" name="price" value="<?php if(isset($_POST['price'])) echo($_POST['price']) ?>" placeholder="※数字" required></td>
    <input type="hidden" name="id" value="<?php echo($row[0]) ?>">

    <td><?php echo $convertibleButton ?></td>
    <td><?php echo $backButton ?></td>
  </tr>
</table>
</form>
<p id="message"><?php echo $message; ?></p>
<br>

<table id="list_table">
<tr>
  <th>商品コード</th><th>メーカー</th><th>素材種類_1</th><th>混率_1</th><th>素材種類_2</th><th>混率_2</th><th>機能・加工</th><th>概要</th><th>価格</th>
</tr>
<?php foreach ($allItems as $row): ?>
  <tr>
    <td><?php echo($row[1]) ?></td><td><?php echo($row[2]) ?></td>
    <td><?php echo($row[3]) ?></td><td><?php echo($row[4]) ?>%</td>
    <td><?php echo($row[5]) ?></td><td><?php echo($row[6]) ?>%</td>
    <td><?php echo($row[7]) ?></td>
    <td><?php echo($row[8]) ?></td>
    <td>￥<?php echo($row[9]) ?></td>
  <!-- <form action="" method="POST"> -->
  <form action="" method="POST">
    <input type="hidden" name="code" value="<?php echo($row[1]) ?>">
    <input type="hidden" name="company" value="<?php echo($row[2]) ?>">
    <input type="hidden" name="material_1" value="<?php echo($row[3]) ?>">
    <input type="hidden" name="rate_1" value="<?php echo($row[4]) ?>">
    <input type="hidden" name="material_2" value="<?php echo($row[5]) ?>">
    <input type="hidden" name="rate_2" value="<?php echo($row[6]) ?>">
    <input type="hidden" name="feature" value="<?php echo($row[7]) ?>">
    <input type="hidden" name="summary" value="<?php echo($row[8]) ?>">
    <input type="hidden" name="price" value="<?php echo($row[9]) ?>">
    
    <td><button type="submit" name="update" value="<?php echo($row[0]) ?>">更新</button></td>
    <td><button type="submit" name="delete" value="<?php echo($row[0]) ?>">削除</button></td>
  </form>
  </tr>
<?php endforeach; ?>
</table>

<script>
function confirmExecution(type){
  // 確認ダイアログ
  var result = window.confirm(type + "してよろしいですか？");
}
</script>
</body>
</html>