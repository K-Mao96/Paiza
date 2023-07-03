<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 2 指定要素の検索
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__single_search/edit?language_uid=php
 */

    // 数字の総数,
    // ターゲットとなる数字 を取得
    fscanf(STDIN, "%d %d", $itemCount, $target);
    
    // デフォルトの答えを「NO」にする
    $result = 'NO';
    
    // ターゲットの数字が見つかった時点でYesを表示する
    for ($i=0; $i<$itemCount; $i++) {
        
        // 対象の数字を取り出す
        fscanf(STDIN, "%d", $item);
        
        // ターゲットと一致したら答えをYesにしてループを抜ける
        if ($item == $target) {
            $result = 'YES';
            break;
        }
        
    }
    
    // 答えを表示する
    echo $result;
    
    
?>