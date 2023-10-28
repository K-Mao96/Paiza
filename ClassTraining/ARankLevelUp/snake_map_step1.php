<?php
/**
 * piza「Aランクレベルアップメニュー」
 * マップの判定・縦横
 * STEP: 1 盤面の情報取得
 * @link https://paiza.jp/works/mondai/a_rank_level_up_problems/a_rank_snake_map_step1/edit?language_uid=php
 */


// 盤面の行数H、列数W、座標の数Nを取得する
[$row, $col, $coordinateAmount] = fscanf(STDIN, "%d %d %d");

// 盤面を表現する配列Aを空で定義
$board = [];
// H回繰り返す
for ($i=0; $i<$row; $i++) {
    // 各行の文字列を取得する
    fscanf(STDIN, "%s", $text);

    // 1文字ずつ区切って配列Bとして定義
    $textList = str_split($text);

    // 配列Aに配列Bを要素として追加
    $board[$i] = $textList;
}

// N回繰り返す
for ($i=0; $i<$coordinateAmount; $i++) {
    // 各行の入力を取得する（y座標、x座業）
    // 半角スペースで区切って別々の変数として定義する
    [$y, $x] = fscanf(STDIN, "%d %d");
    // 配列Aに対して、座標と同じインデックスの要素を文字列をして出力する
    echo $board[$y][$x];
    // 改行を出力する
    echo "\n";
}
?>