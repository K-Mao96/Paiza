<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 8 ソートと検索
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__sort_find_single/edit?language_uid=php
 */

// N、X、Pを取得する
fscanf(STDIN, "%d %d %d", $studentCount, $newStudentHeight, $PaizaHeight);

// 生徒の身長を配列で取得
$studentHeightList = [];
for ($i=0; $i<$studentCount; $i++) {
    fscanf(STDIN, "%d", $studentHeight);
    $studentHeightList[] = $studentHeight;
}


// 配列にPaizaくんの身長を追加
$studentHeightList[] = $PaizaHeight;
// 配列に転校生の身長を追加
$studentHeightList[] = $newStudentHeight;


// 配列を身長の順に並べ替える
sort($studentHeightList);

// 配列のキーと値を反転させる
$studentHeightListAsc = array_flip($studentHeightList);


// Paizaくんの身長が前から何番目か調べる
// MEMO: 0番目, 1番目... というカウント方法になっているため、1を足す
echo $studentHeightListAsc[$PaizaHeight] + 1;

?>