<?php
$res = array();

// 配列の全要素をカンマ付きで列挙
$all_category = [
  'コート', 'ジャケット', 'ポロシャツ', 'Tシャツ'
];
$all_user = [
  'メンズ', 'レディース', '男女共用', 'キッズ'
];
$all_color = [
  '黒', '黄', '青', '赤', '紫', '白', 'ピンク', 'グレー'
];
$all_size = [
  'SS', 'S', 'M', 'L', 'LL', '3L', 'フリー'
];
$all_company = [
  'A社', 'B社', 'C社', 'D社', 'E社'
];

// 変数の初期化（index.phpでの未定義エラー防止のため）
$input_category = array();
$input_user = array();
$input_color = array();
$input_size = array();
$input_company = array();
$input_price = 0; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 外部変数の取得
  $input_category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING); //FILTER_SANITIZE 特殊文字やタグなどを取り除く
  $input_user = filter_input(INPUT_POST, 'user', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); //←配列([])にしなくていいのか？
  $input_color = filter_input(INPUT_POST, 'color', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  $input_size = filter_input(INPUT_POST, 'size', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  $input_company = filter_input(INPUT_POST, 'company', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  $input_price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
  
  // デバッグ出力
  // var_export($input_category);
  // echo "<br>";
  // var_export($input_user);
  // echo "<br>";
  // var_export($input_color);
  // echo "<br>";
  // var_export($input_size);
  // echo "<br>";
  // var_export($input_company);
  // echo "<br>";
  // var_export($input_price);
  // echo "<br>";

  // DB接続（PDOを使用）
  require_once('library.php');

$str = "";
function enum($array) {
  $str = implode("','", $array); //implode(区切り文字, 配列);
  return ("'" . $str . "'");
}
// echo enum($all_category);


// パラメータ数に応じた「?（プレースホルダ）」を用意
if ($input_category !== "") {
  $in_category = substr(str_repeat(',?', 1), 1);
} else {
  $in_category = substr(str_repeat(',?', count($all_category)), 1);
}
  // var_export($in_category);


if (isset($input_user)) {
  $in_user = substr(str_repeat(',?', count($input_user)), 1);
} else {
  $in_user = substr(str_repeat(',?', count($all_user)), 1);
}
if (isset($input_color)) {
  $in_color = substr(str_repeat(',?', count($input_color)), 1);
} else {
  $in_color = substr(str_repeat(',?', count($all_color)), 1);
}
if (isset($input_size)) {
  $in_size = substr(str_repeat(',?', count($input_size)), 1);
} else {
  $in_size = substr(str_repeat(',?', count($all_size)), 1);
}
if (isset($input_company)) {
  $in_company = substr(str_repeat(',?', count($input_company)), 1);
} else {
  $in_company = substr(str_repeat(',?', count($all_company)), 1);
}

$min = 0;
$max = 0;
$in_price = "";
switch ($input_price) {
  case 0:
    break;
  case 1:
    $min = 0;
    $max = 1499;
    break;
  case 2:
    $min = 1500;
    $max = 2999;
    break;
  case 3:
    $min = 3000;
    $max = 5999;
    break;
  case 4:
    $min = 6000;
    $max = 9999;
    break;
  case 5:
    $min = 10000;
    $max = 99999999;
    break;
}
if ($max !== 0) {
  $in_price = " AND price BETWEEN {$min} AND {$max}";
}

// $sql = "SELECT * FROM items WHERE category IN ({$in_category}) AND user IN ({$in_user}) AND color IN ({$in_color}) AND size IN ({$in_size}) AND company IN ({$in_company}) {$in_price}";
$sql = "SELECT * FROM clothes_items WHERE category IN ({$in_category}) AND user IN ({$in_user}) AND color IN ({$in_color}) AND size IN ({$in_size}) AND company IN ({$in_company}) {$in_price}";

// echo $sql . "<br>";

// それぞれ配列にセット
$params = array();
if ($input_category !== "") { // category
  $params[] = $input_category;
} else {
  $params = $all_category;
}

if (isset($input_user)) { // user
  $users = $input_user;
} else {
  $users = $all_user;
  $input_user = ['null']; // エラー対策 Uncaught TypeError: in_array(): Argument #2 ($haystack) must be of type array, null given
}
foreach ($users as $user) {
  $params[] = $user;
}
if (isset($input_color)) { // color
  $colors = $input_color;
} else {
  $colors = $all_color;
  $input_color = ['null']; // エラー対策
}
foreach ($colors as $color) {
  $params[] = $color;
}
if (isset($input_size)) { // size
  $sizes = $input_size;
} else {
  $sizes = $all_size;
  $input_size = ['null']; // エラー対策
}
foreach ($sizes as $size) {
  $params[] = $size;
}
if (isset($input_company)) { // company
  $companies = $input_company;
} else {
  $companies = $all_company;
  $input_company = ['null']; // エラー対策
}
foreach ($companies as $company) {
  $params[] = $company;
}

// var_export($params);
// echo "<br>";

$stmt = $dbh->prepare($sql);
$stmt->execute($params);

$res = $stmt->fetchAll(); 

$num_of_hits = count($res);

// echo "＄res=";
// var_export($res);
// echo "<br>";

}
?>