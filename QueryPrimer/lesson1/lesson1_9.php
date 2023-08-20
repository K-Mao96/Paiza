<?php

use Height as GlobalHeight;

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

// 身長リストクラス
class StudentHeightList {
    static array $list = [];

    // リストに生徒を追加する
    static function addHeight(Height $height): void {
        self::$list[] = $height->getValue();
    }
    // リストを背の順で並べ替える
    static function sortList(): void {
        sort(self::$list);
    }
}

// イベントインターフェース
interface EventInterFace {
    function exec(): void;
}
// joinイベント
class Join implements EventInterFace {
    // 転校生の身長
    public function __construct(public Height $newStudentHeight) 
    {}

    // 処理を実行
    public function exec(): void {
        // 配列に転校生の身長を追加
        StudentHeightList::addHeight($this->newStudentHeight);
    } 
}
// sortイベント
class Sort implements EventInterFace {

    // 処理を実行
    public function exec(): void {
        // 並び替える
        StudentHeightList::sortList();

    }
}
// class Sort implements EventInterFace {

//     public function __construct(public Height $paizaHeight)
//     {}
//     // 処理を実行
//     public function exec(): void {
//         // 並び替える
//         StudentHeightList::sortList();

//         // 結果を表示する
//         echo array_search($this->paizaHeight->getValue(), StudentHeightList::$list) + 1;
//         echo "\n";

//     }
// }

// イベントの種類
class EventType
{
    const JOIN = 'join';
    const SORT = 'sort';

    public EventInterFace $event;

    public function __construct(public string $magicType, public ?Height $paizaHeight, public ?Height $height)
    {
        switch($magicType) {
            case self::JOIN:
                $this->event = new Join($height);
                break;
            case self::SORT:
                $this->event = new Sort($paizaHeight);
                break;
        }
    }

    public function getEventType(): EventInterFace {
        return $this->event;
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
    $paizaHeight = new Height($P);

    // 生徒の身長を配列で取得
    for ($i=0; $i<$studentCount; $i++) {
        fscanf(STDIN, "%d", $height);
        $studentHeight = new Height($height);
        StudentHeightList::addHeight($studentHeight);
    }
    // 配列にPaizaくんの身長を追加
    StudentHeightList::addHeight($paizaHeight);


    // イベントを処理する
    for ($i=0; $i<$eventCount; $i++) {
        $newStudentHeight = null;
        fscanf(STDIN, "%s %d", $eventType, $height);

        // $newStudentHeight = new Height($height);

        // $event = new EventType($eventType, $paizaHeight,  $height);
        // $event->getEventType()->exec();

        if ($eventType === 'join') {
            // 転校生の身長をインスタンス化
            $newStudentHeight = new Height($height);
            // 配列に転校生の身長を追加
            $event = new Join($newStudentHeight);
            $event->exec();
        } else {
            $event = new Sort();
            $event->exec();
            echo array_search($paizaHeight->getValue(), StudentHeightList::$list) + 1;
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