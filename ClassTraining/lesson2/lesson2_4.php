<?php

/**
 * piza「クラス・構造体メニュー」
 * 静的メンバ
 * STEP: 4 クラスの継承
 * @link https://paiza.jp/works/mondai/class_primer/class_primer__inheritance/edit?language_uid=php
 */


/**
 * Chat GPTのリファクタリングを反映
 * CustomerAdultクラスの$alcoholFlgをプロパティ宣言時に初期化するように変更
 * CustomerAdultクラスのsumPriceメソッド内の条件式をわかりやすく変更
 */



/**
 * 顧客クラス(20歳未満)
 */
class Customer {
    //プロパティを定義
    //アルコールの注文種別
    final protected const ALCOHOL_TYPE = 'alcohol';
    
    //コンストラクタを定義
    public function __construct(
        protected int $age,
        protected int $totalCost = 0,
    ) {}
    
    //メソッドを定義
    public function sumPrice (string $orderType, int $price): void {
        //注文種別と金額を受け取る
        //注文種別がアルコールでないならば、合計金額に足し上げていく
        if ($orderType !== self::ALCOHOL_TYPE) {
            $this->totalCost += $price;
        }
    }
    
    public function getTotalCost(): int {
        //合計金額を返す
        return $this->totalCost;
    }   
}

//顧客クラス（20歳以上）
//顧客クラス(20歳未満)を継承
class CustomerAdult extends Customer {
    //プロパティ
        //アルコール注文フラグ
        private bool $alcoholFlg = false;
        //割引金額
        private const DISCOUNT = 200;
        //食事の注文種別
        private const FOOD_TYPE = 'food';
        
    //コンストラクタを定義
    public function __construct(int $age) {
        //親クラスのコンストラクタを実行
        parent::__construct($age);
    }
    
    //sumPriceメソッドをオーバーライド
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
fscanf(STDIN, "%d %d", $totalCustomer, $totalOrder);

//インスタンス化した顧客の情報を配列で管理
$customers = [];

//N回繰り返す
for ($i = 0; $i < $totalCustomer; $i++) {
    //年齢を取得する
    fscanf(STDIN, "%d", $age);
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
    fscanf(STDIN, "%d %s %d", $customerNum, $orderType, $price);
    //顧客のインスタンスに紐づく添字
    $index = $customerNum - 1;
    //該当する顧客番号のインスタンスでメソッドを実行する
    $customer = $customers[$index];
    $customer->sumPrice($orderType, $price);
}

//顧客ごとの合計金額を出力する
foreach ($customers as $customer) {
    $totalCost = $customer->getTotalCost();
    echo $totalCost . "\n";
}
?>