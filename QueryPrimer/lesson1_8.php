<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 8 ソートと検索
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__sort_find_single/edit?language_uid=php
 */

// 例外クラス
class StudentCountException extends Exception {}
class HeightException extends Exception {}

// 生徒数クラス
class StudentCount {
    public function __construct(private int $value)
    {
        if ($value < 1) {
            throw new StudentCountException("生徒数には1以上を指定してください");
        }
        if ($value > 100000) {
            throw new StudentCountException("生徒数には100,000以下を指定してください");
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

// 身長クラス
class Height {
    public function __construct(private int $value)
    {
        if ($value < 100) {
            throw new HeightException("身長には100cm以上を指定してください");
        }
        if ($value > 200) {
            throw new HeightException("身長には200cm以下を指定してください");
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

// N、X、Pを取得する
try {
    fscanf(STDIN, "%d %d %d", $N, $X, $P);

    $studentCountObj = new StudentCount($N);
    $studentCount = $studentCountObj->getValue();

    $newStudentHeightObj = new Height($X);
    $newStudentHeight = $newStudentHeightObj->getValue();

    $paizaHeightObj = new Height($P);
    $paizaHeight = $paizaHeightObj->getValue();

    // 生徒の身長を配列で取得
    $studentHeightList = [];
    for ($i=0; $i<$studentCount; $i++) {
        fscanf(STDIN, "%d", $studentHeight);
        $studentHeightList[] = $studentHeight;
    }


    // 配列にPaizaくんの身長を追加
    $studentHeightList[] = $paizaHeight;
    // 配列に転校生の身長を追加
    $studentHeightList[] = $newStudentHeight;

    // 配列を身長の順に並べ替える
    sort($studentHeightList);

    // Paizaくんの身長が前から何番目か調べる
    // MEMO: 0番目, 1番目... というカウント方法になっているため、1を足す
    echo array_search($paizaHeight, $studentHeightList) + 1;

} catch (StudentCountException $e) {
    echo 'Error:' . $e->getMessage() . "\n";

} catch (HeightException $e) {
    echo 'Error:' . $e->getMessage() . "\n";

} catch (Exception $e) {
    echo 'Error:' . $e->getMessage() . "\n";
}

?>