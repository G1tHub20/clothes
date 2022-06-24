<?php
// htmlspecialcharsを短くする
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES);
}

// DB接続
function dbconnect() {
  try {
    // ローカル用
    $dsn = 'mysql:dbname=clothes;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'mysqlpa55';

    echo "DB接続OK";

    $dbh = new PDO ($dsn, $user, $password, [
    // お決まりのオプション
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //カラム名をキーとする連想配列で取得
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //例外をスロー
    PDO::ATTR_EMULATE_PREPARES => false, //静的プレースホルダ(SQLインジェクション対策)

    ]);
    return $dbh;
  } catch(PDOException $e) {
    echo "DB接続失敗" . $e->getMessage() . "\r\n";
    return $dbh = null;
  }
}

// 変数名自体を取得する
function get_var_name($var) {
  foreach ($GLOBALS as $k => $v) {
      if ($v === $var) {
          return "$" . $k;
      }
  }
  return null;
}

// var_dumpを見やすくする
function d($var) {
  $flag = false;
  if ($flag) {
    echo get_var_name($var);
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
  }
}

// 定数の定義
const NUM = 5; //総問題数
const SUBMIT = '提出する'; //提出するボタン
const NEXT = '次の問題'; //次の問題ボタン

?>