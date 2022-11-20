<?php
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
$all_price = [

];

// var_export($all_category);
$str = "";
function enum($array) {

  $str = implode("','", $array); //implode(区切り文字, 配列);

  return ("'" . $str . "'");
}

echo enum($all_category);

?>