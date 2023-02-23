<?php

/**
 * piza「クラス・構造体メニュー」
 * 静的メンバ
 * STEP: 3 クラスのメンバの更新
 * @link https://paiza.jp/works/mondai/class_primer/class_primer__change_member/edit?language_uid=php
 */


/**
 * 社員クラス
 */
class Employee {

    /**
     * コンストラクタ
     * PHP8.xの省略記法で
     * @param integer $number
     * @param string $name
     */
    public function __construct (
        private int $number,
        private string $name
    ) {}

    //メソッドの定義
    /**
     * 社員番号を返す
     * @return integer
     */
    public function getNum(): int {
        return $this->number;
    }

    /**
     * 社員名を返す
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * 社員番号を変更する
     * @param integer $newNum
     * @return void
     */
    public function changeNum(int $newNum): void {
        $this->number = $newNum;
    }

    /**
     * 社員名を変更する
     * @param string $newName
     * @return void
     */
    public function changeName(string $newName): void {
        $this->name = $newName;
    }


}

//*****************
//  入力取得~出力
//*****************

//入力の回数Nを取得
$totalInput = trim(fgets(STDIN));

//社員のインスタンスを配列で管理する
$employees = [];

//入力をループでN回取得する
for ($i = 1; $i <= $totalInput; $i++) {
    
    //入力を配列に変換
    $input = trim(fgets(STDIN));
    $arrayInput = explode(" ", $input);

    $command = $arrayInput[0];

    //添字は社員番号から1を引いた数
    $index = $arrayInput[1] - 1;
    
    switch ($command) {
        //入力がmake〜の場合は、インスタンスを作成する
        case 'make':
            $number = $arrayInput[1];
            $name   = $arrayInput[2];
            $employee = new Employee($number, $name);
            $employees[] = $employee;
            break;
        
        //入力がgetnum〜の場合は、getnum()を実行する
        case 'getnum':
            //社員番号を取得する
            $output = $employees[$index]->getNum();
            //出力する
            echo $output,"\n";
            break;
        
        //入力がgetname〜の場合は、getname()を実行する 
        case 'getname':
            //社員名を取得する
            $output = $employees[$index]->getName();
            //出力する
            echo $output,"\n";
            break;
        
        //入力がchange_num〜の場合は、changeNum()を実行する 
        case 'change_num':
            //新しい社員番号を取得
            $newNum = $arrayInput[2];
            //社員番号を変更する
            $employees[$index]->changeNum($newNum);
            break;
            
        //入力がchange_num〜の場合は、changeNum()を実行する 
        case 'change_name':
            //新しい社員番号を取得
            $newName = $arrayInput[2];
            //社員番号を変更する
            $employees[$index]->changeName($newName);
            break;

        
        default:
            echo "Invalid input\n";
            break;
    }

}
    
?>