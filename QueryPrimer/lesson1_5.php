<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 5 先頭の要素の削除
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__multi_pop/edit?language_uid=php
 */

// 数字の総数を取得
// 命令の総数を取得
$input = trim(fgets(STDIN));
$inputs = explode(' ', $input);

// MEMO: [$numberListSize, $commandListSize] = $inputs;という書き方もできるが分かりにくいかも
list($numberListSize, $commandListSize) = $inputs;

// 数字のリストを作る
$numberList = [];
for ($i=0; $i<$numberListSize; $i++) {
    fscanf(STDIN, "%d", $number);
    $numberList[] = $number;
}

// 命令のリストを取得する
$commandList = [];
for ($i=0; $i<$commandListSize; $i++) {
    fscanf(STDIN, "%s", $command);
    $commandList[] = $command;
}

// 配列の要素を出力する関数
function echoNumber(int $number) {
    echo $number . "\n";
}

// 命令に沿って配列を操作する
foreach ($commandList as $command) {
    if ($command === "pop") {
        array_shift($numberList);
    }
    if ($command === "show") {
        array_map('echoNumber', $numberList);
    }
}


?>