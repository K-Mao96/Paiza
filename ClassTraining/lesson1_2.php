<?php

//**クラスを使ってリファクタリング
    
    //クラスを作成
    class Student {
        //プロパティ
        public string $name, $birth, $state;
        public int $old;
        
        //コンストラクタ
        public function __construct(array $input) {
            //プロパティを初期化
            // $this->name = $input[0];
            // $this->old = (int)$input[1];
            // $this->birthday = $input[2];
            // $this->state = $input[3];
            list($this->name, $this->old, $this->birth, $this->state) = $input;
        }
        
    }
    
        
    //Nを取得
    $personNum = trim(fgets(STDIN));
    
    //生徒のインスタンスを管理する配列
    $studentList = [];
    
    //N回繰り返す
    for ($i = 1; $i <= $personNum; $i++) {
     //生徒の情報を取得、配列に変換
     $studentInfo = trim(fgets(STDIN));
     $studentInfo = explode(" ", $studentInfo);
     
     //生徒のインスタンスを生成し、要素として追加
     array_push($studentList, new Student($studentInfo));
    }
    
    //Kを取得
    $targetOld = trim(fgets(STDIN));
    
    //$StudentListの各要素のうち、Kを含むものを出力
    foreach ($studentList as $student) {
        if ($student->old == $targetOld) {
            echo $student->name;
        }
    }

    
    ///////////////////////////////////////////

 //※※初回提出コード
    
    //Nを取得
    // $personNum = trim(fgets(STDIN));
    
    //生徒の情報を管理する2次元配列
    // $studentList = [];
    
    //N回繰り返す
    // for ($i = 1; $i <= $personNum; $i++) {
    //  //生徒の情報を取得、配列に変換
    //  $studentInfo = trim(fgets(STDIN));
    //  $studentInfo = explode(" ", $studentInfo);
    //  //$StudentListに要素として追加
    //  array_push($studentList, $studentInfo);
    // }
    
    //Kを取得
    // $targetOld = trim(fgets(STDIN));
    
    //$StudentListの各要素のうち、Kを含むものを抽出
    //抽出したデータの氏名の情報を出力
    // function judgeAndOutput($info) {
    //     global $targetOld;
    //     if ($info[1] == $targetOld) {
    //         echo $info[0];
    //     }
    // }
    // array_map('judgeAndOutput', $studentList);
    
    
    
?>