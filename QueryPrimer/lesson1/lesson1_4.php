<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 4 先頭の要素の削除
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__single_pop?language_uid=php
 */

// 配列の総数を取得
fscanf(STDIN, "%d", $arraySize);

// 配列に要素を追加
$array = [];
for ($i=1; $i<=$arraySize; $i++) {
    fscanf(STDIN, "%d", $item);
    $array[] = $item;
}

// 先頭の要素を削除
// MEMO: array_shift()は参照渡し
array_shift($array);

// 残った要素を出力
foreach($array as $item) {
    echo $item . "\n";
}

?>