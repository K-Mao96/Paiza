<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 2 指定要素の検索 (query)
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__multi_search/edit?language_uid=php&t=ae4ac4ad1f5d0acb11ae22b904512ab0
 */

    // 配列A、Bの要素数を取得する
    [$arrayASize, $targetSize] = fscanf(STDIN, "%d %d");
    
    // 配列Aを取得する
    $arrayA = [];
    for ($i=1; $i<=$arrayASize; $i++) {
        fscanf(STDIN, "%d", $item);
        $arrayA[$item] = true;
    }
    
    // 配列Aの中にターゲットがあったらYES、なければNOを出力する
    // MEMO: 計算量がO(Q log N)になるようにリファクタリング
    for ($i=1; $i<=$targetSize; $i++) {
        fscanf(STDIN, "%d", $target);
        echo isset($arrayA[$target]) ? "YES\n" : "NO\n";
    }

?>