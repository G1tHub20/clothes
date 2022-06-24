<?php
  // $dsn = 'mysql:dbname=clothes;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'mysqlpa55';

$dbh = new mysqli("localhost", $user, $password, "clothes");
if ($dbh->connect_errno) {
    echo "接続しっぱい: " . $mysqli->connect_error;
}

// チェックボックスの値が配列で送られてくるとか
$colors = ["ピンク", "黄", "グレー"];

$sql = 'SELECT * FROM clothes WHERE color IN ('.implode(',', array_fill(0, count($colors), '?')).')'; //配列要素の数「?」を並べる
$stmt = $dbh->prepare($sql);
// idが文字列だったら's'、数値だったら'i'
$stmt->bind_param(str_repeat('s', count($colors)), ...$colors); //「s」を配列要素の数並べる（str_repeat）、可変長引数
$stmt->execute();
$res = $stmt->get_result();

print_r($res);



?>