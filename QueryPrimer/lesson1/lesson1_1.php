<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 1 指定の位置への要素の追加
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__single_insertion/edit?language_uid=php
 */

    // 入力を取得
    fscanf(STDIN, "%d %d %d", $arrayLength, $point, $newItem);
    
    // 配列を定義
    $array = [];
    for($i = 1; $i <= $arrayLength; $i++) {
        
        // 配列の要素を取得
        fscanf(STDIN, "%d", $arrayItem);
        
        // 指定されたポイントに新しい要素を追加する
        if ($i == $point + 1) {
            $array[] = $newItem;
        }
        
        // 既存の要素を配列に追加
        $array[] = $arrayItem;
    }

    // 要素を出力
    foreach ($array as $item) {
        echo $item . "\n";
        
    }
?>