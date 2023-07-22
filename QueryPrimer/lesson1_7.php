<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 7 連想配列
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__map_normal/edit?language_uid=php
 */

// 例外クラスの定義
class StudentNumberException extends Exception {}
class StudentIdException extends Exception {}

// 出席番号クラス
class StudentNumber {
    public int $value;

    public function __construct(int $value) {

        if ($value < 1) {
            throw new Exception("出席番号には1以上を指定してください");
        }
        if ($value > 1000000) {
            throw new Exception("出席番号には1000000以下を指定してください");
        }
        
        $this->value = $value;
    }
}

// 生徒IDクラス
class StudentId {
    public string $value;

    public function __construct(string $value) {
        $pattern = '/^[a-zA-Z0-9]+$/';

        if (!preg_match($pattern, $value)) {
            throw new Exception("生徒IDにはアルファベット大文字小文字(a ~ z , A ~ Z)と数字(0 ~ 9)のみを使用してください");
        }
        if (strlen($value) > 20) {
            throw new Exception("生徒IDは20文字以下で入力してください");
        }
        
        $this->value = $value;
    }
}
// 生徒クラス
class Student {
    function __construct(
        public StudentNumber $studentNum,
        public StudentId $studentId,
        public bool $forgetFlg = false,
    ) {
    }

    /**
     * 生徒を忘れる
     *
     * @param integer $studentNum
     * @return void
     */
    public function forgetStudent():void {
        $this->forgetFlg = true;
    } 

    /**
     * 生徒番号を返す
     *
     * @return integer
     */
    public function getStudentNum(): int {
        return $this->studentNum->value;
    }

    /**
     * 生徒の識別IDを返す
     *
     * @return string
     */
    public function getStudentId(): string {
        return $this->studentId->value;
    }
}

try {

    // 生徒の初期人数と、与えられるイベントの数を取得
    $input = trim(fgets(STDIN));
    $inputs = explode(' ', $input);
    list($initialStudentSize, $givenEventSize) = $inputs;

    // 全ての生徒の生徒クラスインスタンスを生成する
    $studentList = [];
    for ($i=0; $i<$initialStudentSize; $i++) {
        $input = trim(fgets(STDIN));
        $inputs = explode(' ', $input);
        list($num, $id) = $inputs;
        $studentNum = new StudentNumber($num);
        $studentId = new StudentId($id);

        $studentList[$studentNum->value] = new Student($studentNum, $studentId);
    }

    // 与えられるイベントに対応する処理を行う
    for ($i=0; $i<$givenEventSize; $i++) {
        // 与えられるイベントと生徒番号を取得
        $input = trim(fgets(STDIN));
        $inputs = explode(' ', $input);
        $id = null;
        if (count($inputs) === 3) {
            list($event, $num, $id) = $inputs;
        } else {
            list($event, $num) = $inputs;
        }

        

        // 生徒番号をインスタンス化
        $studentNum = new StudentNumber($num);

        // 生徒IDをインスタンス化
        $studentId = $id ? new StudentId($id) : null;

        // 与えられた生徒番号に対応する生徒インスタンスを取得
        $targetStudent = $studentList[$studentNum->value];

        // イベントを実行
        switch ($event) {
            case 'call':
                $studentId = $targetStudent->getStudentId();
                echo $studentId . "\n";
                break;

            case 'leave':
                $targetStudent->forgetStudent();
                break;
            case 'join':
                // MEMO: 同じ生徒番号の生徒が既に存在している場合は上書きされる
                $studentList[$studentNum->value] = new Student($studentNum, $studentId);
                break;
        }
        var_dump($studentList);

    }
} catch (StudentNumberException $e) {
    echo 'Error:' . $e->getMessage() . "\n";

} catch (StudentIdException $e) {
    echo 'Error:' . $e->getMessage() . "\n";

} catch (Exception $e) {
    echo 'Error:' . $e->getMessage() . "\n";
}

?>