<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 8 ソートと検索
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__sort_find_single/edit?language_uid=php
 */

// 生徒数クラス
class StudentCount {
    public function __construct(private int $value)
    {
        if ($value < 1) {
            throw new Exception("生徒数には1以上を指定してください");
        }
        if ($value > 100000) {
            throw new Exception("生徒数には100,000以下を指定してください");
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}


// N、X、Pを取得する
fscanf(STDIN, "%d %d %d", $N, $newStudentHeight, $PaizaHeight);

$studentCountObj = new StudentCount($N);
$studentCount = $studentCountObj->getValue();

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

// Paizaくんの身長が前から何番目か調べる
// MEMO: 0番目, 1番目... というカウント方法になっているため、1を足す
echo array_search($PaizaHeight, $studentHeightList) + 1;

?>