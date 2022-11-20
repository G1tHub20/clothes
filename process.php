<?php
require_once('library.php');

$items = array();

// 配列の全要素をカンマ付きで列挙 // 選択肢を配列に格納
$stmt = $dbh->query("SELECT DISTINCT material_1  FROM clothes_items2"); //material ★material_2の値を考慮する必要
$all_material = $stmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $dbh->query("SELECT DISTINCT company  FROM clothes_items2"); //company
$all_company = $stmt->fetchAll(PDO::FETCH_COLUMN);

$all_rate = [
  '100','90','80','70','60','50','40','30','20','10','5'  //rate
];

$stmt = $dbh->query("SELECT DISTINCT feature  FROM clothes_items2"); //feature
$all_feature = $stmt->fetchAll(PDO::FETCH_COLUMN);
// var_export($all_feature);

// 変数の初期化（index.phpでの未定義エラー防止のため）
$input_material = array();
$input_rate = 0; 
$input_feature = array();
$input_freeword = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 外部変数の取得
  $input_material = filter_input(INPUT_POST, 'material', FILTER_SANITIZE_STRING); //FILTER_SANITIZE 特殊文字やタグなどを取り除く
  $input_rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_NUMBER_INT);
  // $input_feature = filter_input(INPUT_POST, 'feature', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); //配列を受け取る場合
  $input_feature = filter_input(INPUT_POST, 'feature', FILTER_SANITIZE_STRING);
  $input_freeword = filter_input(INPUT_POST, 'freeword', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
  
  // デバッグ出力
  // var_export($input_material);
  // echo "<br>";
  // var_export($input_rate);
  // echo "<br>";
  // var_export($input_feature);
  // echo "<br>";
  // var_export($input_freeword);
  // echo "<br>";

$str = "";
function enum($array) {
  $str = implode("','", $array); //implode(区切り文字, 配列);
  return ("'" . $str . "'");
}
// echo enum($all_material);

// パラメータ数に応じた「?（プレースホルダ）」を用意
if ($input_material !== "") {
  $in_material = substr(str_repeat(',?', 1), 1);
} else {
  $in_material = substr(str_repeat(',?', count($all_material)), 1);
}
$in_rate = substr(str_repeat(',?', 1), 1);
// var_export($in_material);

if (isset($input_feature)) {
  // $in_feature = substr(str_repeat(',?', count($input_feature)), 1);
  $in_feature = substr(str_repeat(',?', 1), 1);
  // exit($in_feature);
} else {
  $in_feature = substr(str_repeat(',?', count($all_feature)), 1);
}
if ($input_freeword == "") { //freeword
  $in_freeword = "";
} else {
  $in_freeword = "AND summary LIKE '%{$input_freeword}%'";
}

$sql = "SELECT * FROM clothes_items2 WHERE (material_1 IN ({$in_material}) AND rate_1 >= {$in_rate} OR material_2 IN ({$in_material}) AND rate_2 >= {$in_rate}) AND feature IN ({$in_feature}) {$in_freeword}";
// $sql = "SELECT * FROM clothes_items2 WHERE (material_1 IN ({$in_material}) AND rate_1 >= {$in_rate} OR material_2 IN ({$in_material}) AND rate_2 >= {$in_rate}) AND feature IN ({$in_feature}) {$in_freeword}";
// echo $sql . "<br>";

// 各値をバインド用の配列にセット
$params = array();
if ($input_material !== "") { //material と rate
  $params[] = $input_material;
  $params[] = $input_rate;
  $params[] = $input_material; //items2テーブルのmaterial_1とmaterial_2の2個所を検索するため
  $params[] = $input_rate;
} else { // meaterial未選択時のエラー対策
  $params = $all_material;
  $params[] = 0;
  foreach ($all_material as $material) {
    $params[] = $material;
  }
  $params[] = 0;
}
if (isset($input_feature)) { //feature
  $feature = $input_feature;
  $params[] = $feature;
} else {
  $feature = $all_feature;
  // var_export($all_feature);
  foreach ($all_feature as $feature) {
    $params[] = $feature;
  }
}
// var_export($params);
// echo "<br>";

$stmt = $dbh->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll(); 
$num_of_hits = count($items);
// var_export($items);
// echo "<br>";

}
?>