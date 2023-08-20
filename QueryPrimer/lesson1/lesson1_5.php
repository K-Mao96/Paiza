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

// キューに数字をセットする
$numberQueue = new SplQueue();
for ($i = 0; $i < $numberListSize; $i++) {
    fscanf(STDIN, "%d", $number);
    $numberQueue->enqueue($number);
}

for ($i = 0; $i < $commandListSize; $i++) {
    // 命令を取り出す
    fscanf(STDIN, "%s", $command);

    // popの場合はキューの先頭の要素を取り出す
    if ($command === "pop") {
        $numberQueue->dequeue();
        continue;
    }
    foreach ($numberQueue as $number) {
        echo $number . "\n";
    }
}




?>