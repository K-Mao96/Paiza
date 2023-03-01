<?php

/**
 * piza「クラス・構造体メニュー」
 * 静的メンバ
 * STEP: FINAL問題 静的メンバ
 * @link https://paiza.jp/works/mondai/class_primer/class_primer__static_member/edit?language_uid=php
 */

/**
 * 顧客クラス
 */
class Customer {
    
    //退店した人数
    protected static int $totalLeaveCustomer = 0;

    //ソフトドリンクの注文種別
    final public const SOFT_DRINK_TYPE = 'softdrink';
    //食事の注文種別
    final public const FOOD_TYPE = 'food';
    //退店の注文種別
    final public const LEAVE_TYPE = 'A';
    
    
    /**
     * コンストラクタ
     * 
     * @param integer $age 顧客の年齢
     * @param integer $totalCost 合計金額
     */
    public function __construct(
        protected int $age,
        protected int $totalCost = 0,
    ) {}


    /**
     * 合計金額を計算する
     *
     * @param string $orderType 注文種別
     * @param integer $price 価格
     * @return void
     */
    public function sumPrice (int $price): void {
        //合計金額に足し上げていく
        $this->totalCost += $price;
    }
    
    /**
     * アルコールが注文された時の処理（何もしない）
     * 
     * @param integer $price 価格
     * @return void
     */
    public function takeAlcohol (int $price = CustomerAdult::BEER_PRICE) {}

    /**
     * ソフトドリンクが注文された時の処理
     * 
     * @param integer $price  価格
     * @return void
     */
    public function takeSoftDrink (int $price): void {
        $this->sumPrice($price);
    }

    /**
     * 食事が注文された時の処理
     * 
     * @param integer $price 価格
     * @return void
     */
    public function takeFood (int $price): void {
        $this->sumPrice($price);
    }
    

    /**
     * 退店時の処理
     *
     * @return void
     */
    public function leaveStore (): void {
        self::$totalLeaveCustomer ++;
    }
    
    /**
     * 合計金額を返す
     * 
     * @return integer
     */
    public function getTotalCost(): int {
        return $this->totalCost;
    }
    
    /**
     * 退店した人数を返す
     *
     * @return integer
     */
    public static function getTotalLeaveCustomer(): int {
        return self::$totalLeaveCustomer;
    }
}


/**
 * 顧客クラス（20歳以上）
 */
class CustomerAdult extends Customer {
    /**
     * アルコール注文フラグ
     * 
     * @var boolean
     */
    private bool $alcoholFlg = false;
    //アルコールの注文種別
    public const ALCOHOL_TYPE = 'alcohol';
    //アルコール注文による割引金額
    private const DISCOUNT = 200;
    //ビールの注文種別
    public const BEER_TYPE = 0;
    //ビールの値段
    final protected const BEER_PRICE = 500;
    


    /**
     * アルコールが注文された時の処理（オーバーライド）
     *
     * @param integer $price 価格
     * @return void
     */
    public function takeAlcohol (int $price = self::BEER_PRICE): void {
        //アルコール注文フラグを立てる(1回だけ)
        if (!$this->alcoholFlg) {
            $this->alcoholFlg = true;
        }
        
        $this->sumPrice($price);
    }

    /**
     * 食事が注文された時の処理（オーバーライド）
     *
     * @param integer $price 価格
     * @return void
     */
    public function takeFood (int $price): void {
        //アルコール注文フラグが立っていたら、割引を適用する
        if ($this->alcoholFlg) {
            $price -= self::DISCOUNT;
        }
        $this->sumPrice($price);
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
    $customer = ($age < 20) ? new Customer($age) : new CustomerAdult($age);
    //配列に追加
    $customers[] = $customer;
}

//K回繰り返す
for ($i = 0; $i < $totalOrder; $i++) {
    //入力を取得する
    $input = trim(fgets(STDIN));
    $input = explode(" ", $input);
    //顧客の番号, 注文種別
    $customerNum = $input[0];
    $orderType   = $input[1];
    
    //顧客のインスタンスの添字を取得
    $index = $customerNum - 1;
    
    //顧客のインスタンスを取得
    $customer = $customers[$index];
    

    switch ($orderType) {
        //ビールが注文された場合
        case CustomerAdult::BEER_TYPE:
            $customer->takeAlcohol();
            break;
        
        //その他のアルコールが注文された場合
        case CustomerAdult::ALCOHOL_TYPE:
            $price = $input[2];
            $customer->takeAlcohol($price);
            break;
        
        //ソフトドリンクが注文された場合
        case Customer::SOFT_DRINK_TYPE:
            $price = $input[2];
            $customer->takeSoftDrink($price);
            break;
            
        //食事が注文された場合
        case Customer::FOOD_TYPE:
            $price = $input[2];
            $customer->takeFood($price);
            break;
            
        //退店する場合
        case Customer::LEAVE_TYPE:
            $customer->leaveStore();
            echo $customer->getTotalCost() . "\n";
            break;
        
        //許可されていない入力の場合
        default:
            echo 'invalid input'."\n";
            break;
    }


}

//退店した人数を出力する
echo Customer::getTotalLeaveCustomer();


?>