<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 2 指定要素の検索
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__single_search/edit?language_uid=php
 */

    // 数字の総数とターゲットとなる数字を取得
    // MEMO: 分割代入を活用
    [$itemCount, $target] = fscanf(STDIN, "%d %d");
    
    // ターゲットの数字が見つかったかどうかを示すフラグ変数
    // MEMO: 「リーダブルコード」, p.34
    // bool値の変数名にはis/has/can/shouldなどをつけてわかりやすくする
    $hasTarget = false;
    
    for ($i=0; $i<$itemCount; $i++) {
        
        // 対象の数字を取り出す
        fscanf(STDIN, "%d", $item);
        
        // 数字を取得し、ターゲットが存在する場合はフラグ変数をtrueにしてループを抜ける
        // MEMO: 「良いコード悪いコード..」, p.133
        // 早期breakでネストを解消する
        if ($item == $target) {
            $hasTarget = true;
            break;
        }
        
    }
    
    // 答えを表示する
    echo $hasTarget ? 'YES' : 'NO';
    
    
?>