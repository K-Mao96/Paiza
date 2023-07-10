<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 4 先頭の要素の削除
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__single_pop?language_uid=php
 */

// 配列の総数を取得
fscanf(STDIN, "%d", $arraySize);

// 先頭の要素以外を出力
for ($i=1; $i<=$arraySize; $i++) {
    fscanf(STDIN, "%d", $item);
    if ($i >= 2) {
        echo $item . "\n";
    }
}

?>