<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 9 ソートと検索
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__sort_find_multi/edit?language_uid=php
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

// イベント回数クラス
class EventCount {
    public function __construct(private int $value)
    {
        if ($value < 1) {
            throw new StudentCountException("イベントの回数には1以上を指定してください");
        }
        if ($value > 100000) {
            throw new StudentCountException("イベントの回数には100,000以下を指定してください");
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

try {
    // N、X、Pを取得する
    fscanf(STDIN, "%d %d %d", $N, $K, $P);

    // Paizaくん以外の生徒の数
    $studentCountObj = new StudentCount($N);
    $studentCount = $studentCountObj->getValue();

    // イベントの回数
    $eventCountObj = new EventCount($K);
    $eventCount = $eventCountObj->getValue();

    // Paiza君の身長
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


    // イベントを処理する
    for ($i=0; $i<$eventCount; $i++) {
        $newStudentHeight = null;
        fscanf(STDIN, "%s %d", $eventName, $height);

        if ($eventName === 'join') {
            // 転校生の身長をインスタンス化
            $newStudentHeightObj = new Height($height);
            $newStudentHeight = $newStudentHeightObj->getValue();
            // 配列に転校生の身長を追加
            $studentHeightList[] = $newStudentHeight;
        } else {
            // 配列を身長の順に並べ替える
            sort($studentHeightList);

            // Paizaくんの身長が前から何番目か調べる
            // MEMO: 0番目, 1番目... というカウント方法になっているため、1を足す
            echo array_search($paizaHeight, $studentHeightList) + 1;
            echo "\n";
        }
    }

} catch (StudentCountException $e) {
    echo 'Error:' . $e->getMessage() . "\n";

} catch (HeightException $e) {
    echo 'Error:' . $e->getMessage() . "\n";

} catch (Exception $e) {
    echo 'Error:' . $e->getMessage() . "\n";
}

?>