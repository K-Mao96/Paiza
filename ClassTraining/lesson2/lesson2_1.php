<?php

/**
 * piza「クラス・構造体メニュー」
 * 静的メンバ
 * STEP: 1 クラスの作成
 * @link https://paiza.jp/works/mondai/class_primer/class_primer__make_class/edit?language_uid=php
 */


    /**
     * 従業員クラス
     */
    class Employee {

        /**
         * コンストラクタ
         * PHP8.xの省略記法で
         * @param integer $number
         * @param string $name
         */
        public function __construct(public int $number, public string $name) {
            
        }
        
        //メソッドの定義
        /**
         * 従業員番号を返す
         * @return integer
         */
        public function getNum(): int {
            return $this->number;
        }
        
        /**
         * 従業員名を返す
         * @return string
         */
        public function getName(): string {
            return $this->name;
        }
    }
    
    //*****************
    //  入力取得~出力
    //*****************

    //入力の回数Nを取得
    $totalInput = trim(fgets(STDIN));
    
    //従業員のインスタンスを配列で管理する
    $employeeList = [];
    
    //入力をループでN回取得する
    for ($i = 1; $i <= $totalInput; $i++) {
        
        //入力を配列に変換
        $input = trim(fgets(STDIN));
        $arrayInput = explode(" ", $input);

        $command = $arrayInput[0];
        
        switch ($command) {
            //入力がmake〜の場合は、インスタンスを作成する
            case 'make':
                $number = $arrayInput[1];
                $name   = $arrayInput[2];
                $employee = new Employee($number, $name);
                array_push($employeeList, $employee);
                break;
            
            //入力がgetnum〜の場合は、getnum()を実行する
            case 'getnum':
                //添字は従業員番号から1を引いた数
                $index = $arrayInput[1] - 1;
                //従業員番号を取得する
                $output = $employeeList[$index]->getNum();
                //出力する
                echo $output,"\n";
                break;
            
            //入力がgetname〜の場合は、getname()を実行する 
            case 'getname':
                //添字は従業員番号から1を引いた数
                $index = $arrayInput[1] - 1;
                //従業員名を取得する
                $output = $employeeList[$index]->getName();
                //出力する
                echo $output,"\n";
                break;
        }

    }
    
?>