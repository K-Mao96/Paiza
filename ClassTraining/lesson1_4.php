<?php

//生徒クラス
class Student {

    //生徒の基本情報
    public string $name; //氏名
    public int    $old;  //年齢
    public string $birth;//生月日
    public string $state;//出身地

    /**
     * 基本情報を初期化する
     * @param array $input {
     *  name:  string,
     *  old:   int,
     *  birth: string,
     *  state: string
     * }
     */
    public function __construct(array $input) {
        list($this->name, $this->old, $this->birth, $this->state) = $input;
    }
    
    //changeNameメソッド：生徒の名前を変更する
    //パラメータ：対象の生徒インスタンス、新しい名前
    public static function changeName($studentObj, $newName): void {
        $studentObj->name = $newName;
    }
 
}



//生徒の人数(N)を取得
$inputFirstLine = trim(fgets(STDIN));
$arrayFirstLine = explode(" ", $inputFirstLine);
$totalStudent = $arrayFirstLine[0];

//生徒のインスタンスを管理する配列を定義
$studentList = [];

//生徒の数だけインスタンスを作り、studentListに格納
for ($i = 1; $i <= $totalStudent; $i++) {
    //生徒1人分の情報を取得
    $input = trim(fgets(STDIN));
    //配列に変換する
    $input = explode(" ", $input);
    array_push($studentList, new Student($input));
}




//名前を変更する生徒の人数を取得
$totalchangeStudent = $arrayFirstLine[1];

//変更する生徒の情報を格納する配列を定義
$changeStudentList = [];

//変更対象の生徒の情報を取得
for ($i = 1; $i <= $totalchangeStudent; $i++) {
    $input = trim(fgets(STDIN));
    $input = explode(" ", $input);
    array_push($changeStudentList, $input);
}

//名前を変更
foreach ($changeStudentList as $changeStudent) {
    //生徒番号を取得
    //$studentListのindexとするので、1を引く
    $targetIndex = $changeStudent[0] - 1;
    
    //変更後の名前を取得
    $newName = $changeStudent[1];
    
    //生徒の名前を変更
    Student::changeName($studentList[$targetIndex], $newName);
}

//出力する
foreach ($studentList as $student) {
    echo $student->name, " ", $student->old, " ", $student->birth, " ", $student->state, "\n";
}


?>