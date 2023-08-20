<?php

/**
 * piza「クエリメニュー」
 * Vtuber
 * STEP: 1 アイドルグループ
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__idle_group/edit?language_uid=php
 */

// 初期メンバー数、イベントの回数を定義
fscanf(STDIN, "%d %d", $N, $K);

// メンバーリスト
$memberList = [];
for ($i=0; $i<$N; $i++) {
    fscanf(STDIN, "%s", $name);
    $memberList[$name] = 0;
}

// イベントを実行
for ($i=0; $i<$K; $i++) {
    fscanf(STDIN, "%s %s", $event, $name);

    switch ($event) {
        case 'join':
            $memberList[$name] = 0;
            break;
        case 'leave':
            unset($memberList[$name]);
            break;
        case 'handshake':
            ksort($memberList);
            foreach ($memberList as $key => $member) {
                echo $key . "\n";
            }
    }

}


?>