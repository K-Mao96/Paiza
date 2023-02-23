<?php

/**
 * piza「クラス・構造体メニュー」
 * 静的メンバ
 * STEP: 4 クラスの継承
 * @link https://paiza.jp/works/mondai/class_primer/class_primer__inheritance/edit?language_uid=php
 */


//お客クラス(20歳未満)
class Customer {
    //プロパティを定義
    //アルコールの注文種別
    protected const ALCOHOL_TYPE = 'alcohol';
    
    //コンストラクタを定義
    public function __construct(
        protected int $age,
        protected int $totalCost = 0,
    ) {}
    
    //メソッドを定義
    public function sumPrice (string $orderType, int $price): void {
        //注文種別と金額を受け取る
        //注文種別がアルコールでないならば、合計金額に足し上げていく
        if ($orderType === self::ALCOHOL_TYPE) {
            return;
        } else {
            $this->totalCost += $price;
        }
    }
    
    public function getTotalCost(): int {
        //合計金額を返す
        return $this->totalCost;
    }   
}

//お客クラス（20歳以上）
//お客クラス(20歳未満)を継承
class CustomerAdult extends Customer {
    //プロパティ
        //アルコール注文フラグ
        private bool $alcoholFlg;
        //割引金額
        private const DISCOUNT = 200;
        //食事の注文種別
        private const FOOD_TYPE = 'food';
        
    //コンストラクタを定義
    public function __construct(int $age) {
        //親クラスのコンストラクタを実行
        parent::__construct($age);
        //アルコール注文フラグをリセット
        $this->alcoholFlg = false;
    }
    
    //メソッドを変更 or 追加
    public function sumPrice (string $orderType, int $price): void {
        //アルコールが注文されたら、注文フラグをtrueにする（1回だけ）
        if (!$this->alcoholFlg && $orderType === self::ALCOHOL_TYPE) {
            $this->alcoholFlg = true;
        }
        
        //合計金額に足し上げる
        $this->totalCost += $price;
        
        //アルコール注文フラグがtrueかつ注文種別が「食事」なら、割引を適用する
        if ($this->alcoholFlg && $orderType === self::FOOD_TYPE) {
            $this->totalCost -= self::DISCOUNT;
        }
    }
        
}

//入力を取得
$input = trim(fgets(STDIN));
$input = explode(" ", $input);
    //お客の人数Nを取得
    $totalCustomer = $input[0];
    //注文の回数Kを取得
    $totalOrder = $input[1];

//インスタンス化したお客の情報を配列で管理
$customers = [];

//N回繰り返す
for ($i = 0; $i < $totalCustomer; $i++) {
    //年齢を取得する
    $age = trim(fgets(STDIN));
    //インスタンス化
    if ($age < 20) {
        //20歳未満なら
        $customer = new Customer($age);
    } else {
        //20歳以上なら
        $customer = new CustomerAdult($age);
    }
    //配列に追加
    $customers[] = $customer;
}

//K回繰り返す
for ($i = 0; $i < $totalOrder; $i++) {
    //入力を取得する
    $input = trim(fgets(STDIN));
    $input = explode(" ", $input);
    //お客の番号, 注文種別, 金額
    $index       = $input[0] - 1;
    $orderType   = $input[1];
    $price       = $input[2];
    //該当するお客番号のインスタンスでメソッドを実行する
    $customer = $customers[$index];
    $customer->sumPrice($orderType, $price);
}

//お客ごとの合計金額を出力する
foreach ($customers as $customer) {
    $totalCost = $customer->getTotalCost();
    echo $totalCost . "\n";
}
?>