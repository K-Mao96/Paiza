<?php

/**
 * piza「クエリメニュー」
 * ソートと検索 (query)
 * STEP: 5 連想配列
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__map_easy?language_uid=php
 */

// 例外クラスの定義
class StudentNumberException extends Exception {}
class StudentIdException extends Exception {}

// 出席番号クラス
class StudentNumber {
    public int $value;

    public function __construct(int $value) {

        if ($value < 0) {
            throw new Exception("出席番号には0以上を指定してください");
        }
        if ($value > 10000) {
            throw new Exception("出席番号には10000以下を指定してください");
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
        public StudentId $studentId
    ) {
    }

    public function getStudentNum(): int {
        return $this->studentNum->value;
    }

    public function getStudentId(): string {
        return $this->studentId->value;
    }
}

try {

    // 生徒の人数と、与えられる出席番号の数を取得
    $input = trim(fgets(STDIN));
    $inputs = explode(' ', $input);
    list($studentSize, $givenStudentNumSize) = $inputs;

    // 全ての生徒の生徒クラスインスタンスを生成する
    $studentList = [];
    for ($i=0; $i<$studentSize; $i++) {
        $input = trim(fgets(STDIN));
        $inputs = explode(' ', $input);
        list($num, $id) = $inputs;
        $studentNum = new StudentNumber($num);
        $studentId = new StudentId($id);

        $studentList[$studentNum->value] = new Student($studentNum, $studentId);
    }

    // 与えられる出席番号に対応する生徒IDを出力する
    $givenStudentNumList = [];
    for ($i=0; $i<$givenStudentNumSize; $i++) {
        // 与えられる出席番号を取得
        fscanf(STDIN, "%d", $givenStudentNum);

        // 与えられた出席番号に対応する生徒のインスタンスを取得
        $targetStudent = $studentList[$givenStudentNum];

        // 生徒IDと改行を出力
        echo $targetStudent->getStudentId();
        echo "\n";
    }
} catch (StudentNumberException $e) {
    echo 'Error:' . $e->getMessage() . "\n";

} catch (StudentIdException $e) {
    echo 'Error:' . $e->getMessage() . "\n";

} catch (Exception $e) {
    echo 'Error:' . $e->getMessage() . "\n";
}

?>