<?php
    //生徒クラス
    class Student {
        //プロパティ
        public string $name; //氏名
        public int    $old;  //年齢
        public string $birth;//生月日
        public string $state;//出身地
        
        //プロパティを初期化
        public function __construct(array $input) {
            list($this->name, $this->old, $this->birth, $this->state) = $input;
        }
    }

    
    
    //生徒の人数(N)を取得
    $totalStudent = trim(fgets(STDIN));

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
    
    //oldが若い順にstudentListの要素を並べ替える
    $old  = array_column($studentList, 'old');
    array_multisort($old, SORT_ASC, $studentList);

    //並べ替えた順で出力する
    foreach ($studentList as $student) {
        echo $student->name, " ", $student->old, " ", $student->birth, " ", $student->state, "\n";
    }
?>