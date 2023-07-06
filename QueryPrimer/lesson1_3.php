<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 2 指定要素の検索 (query)
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__single_search/edit?language_uid=php
 */

    // 配列A、Bの要素数を取得する
    [$arrayASize, $arrayBSize] = fscanf(STDIN, "%d %d");
    
    // 配列Aを取得する
    $arrayA = [];
    for ($i=1; $i<=$arrayASize; $i++) {
        fscanf(STDIN, "%d", $item);
        $arrayA[] = $item;
    }
    
    // 配列Bを取得する
    $arrayB = [];
    for ($i=1; $i<=$arrayBSize; $i++) {
        fscanf(STDIN, "%d", $item);
        $arrayB[] = $item;
    }
    
    // 配列Aの中に配列Bの要素があったらYES、なければNOを出力する
    foreach($arrayB as $itemB) {
        echo in_array($itemB, $arrayA) ? "YES\n" : "NO\n";
    }
    
    
?>