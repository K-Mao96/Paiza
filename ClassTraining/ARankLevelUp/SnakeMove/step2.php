<?php

/**
 * piza「Aランクレベルアップメニュー」
 * 座標系での向きの変わる移動
 * STEP: 2 座標系での移動・方角
 * @link https://paiza.jp/works/mondai/a_rank_level_up_problems/a_rank_snake_move_step2/edit?language_uid=php
 */

// 現在地クラス
class Point
 {
    // y座標
    private int $y;
    // x座標
    private int $x;

    public function __construct(int $y, int $x)
    {
        if ($y < 0 || $x < 0) {
            throw new RowAmoutException("座標には0以上を指定してください");
        }
        if ($y > 100 || $x > 100) {
            throw new RowAmoutException("座標には100以下を指定してください");
        }

        $this->y = $y;
        $this->x = $x;
    }

    // 移動する
    public function move(Direction $directionObj): void
    {
        // 差分を取得する
        $diffY = $directionObj->getDiffY();
        $diffX = $directionObj->getDiffX();

        // 移動する
        $this->y = $this->y + $diffY;
        $this->x = $this->x + $diffX;
    }

    // 現在地を出力する
    public function echoPoint(): void
    {
        echo $this->y;
        echo " ";
        echo $this->x;
        echo "\n";
    }

 }

// 移動回数クラス
class MovingFrequency
{
    // 移動回数
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new RowAmoutException("移動回数には0以上を指定してください");
        }
        if ($value > 100) {
            throw new RowAmoutException("移動回数には100以下を指定してください");
        }

        $this->value = $value;
    }

    // 移動回数を取得する
    public function getValue(): int
    {
        return $this->value;
    }
}

// 移動方向クラス
class Direction
{
    // 移動によるY座標の差分
    private int $diffY;

    // 移動によるX座標の差分
    private int $diffX;

    // 移動方向のリスト
    private const NORTH = "N";
    private const SOUTH = "S";
    private const EAST  = "E";
    private const WEST  = "W";

    public function __construct(string $direction)
    {
        // 初期の差分は0
        $this->diffY = 0;
        $this->diffX = 0;

        switch ($direction) {
            // NならY座標を-1
            case self::NORTH :
                $this->diffY = -1;
                break;
        
            // SならY座標を+1
            case self::SOUTH :
                $this->diffY = 1;
                break;
        
            // EならX座標を+1
            case self::EAST :
                $this->diffX = 1;
                break;
        
            // WならX座標を-1
            case self::WEST :
                $this->diffX = -1;
                break;

            // いずれの方向でもない場合はエラーを出力
            default :
                throw new RowAmoutException("移動方向にはN・S・E・Wのいずれかを指定してください");
        }
    }

    // MEMO: 移動方向クラスに差分の情報があるのは変かも
    // Y座標の差分を取得
    public function getDiffY(): int
    {
        return $this->diffY;
    }

    // X座標の差分を取得
    public function getDiffX(): int
    {
        return $this->diffX;
    }
}

// 移動を実行するクラス
class Moving
{
    // 現在地
    private Point $pointObj;
    // 移動の回数
    private MovingFrequency $movingFrequencyObj;

    public function __construct(Point $pointObj, MovingFrequency $movingFrequencyObj)
    {
        $this->pointObj = $pointObj;
        $this->movingFrequencyObj = $movingFrequencyObj;
    }

    public function exec(): void
    {
        // 移動の回数を取得
        $movingFrequency = $this->movingFrequencyObj->getValue();

        for ($i=0; $i<$movingFrequency; $i++) {
            // 標準入力から移動方向を取得する
            fscanf(STDIN, "%s", $d);
            $directionObj = new Direction($d);

            // 座標を移動する
            $this->pointObj->move($directionObj);

            // 移動後の現在地を出力する
            $this->pointObj->echoPoint();
        }

    }
}


// 標準入力から、Y座標、X座標、移動の回数を取得する
[$startY, $startX, $n] = fscanf(STDIN, "%d %d %d");

// 現在地
$pointObj = new Point($startY, $startX);

// 移動の回数
$movingFrequencyObj = new MovingFrequency($n);

// 移動する
$movingObj = new Moving($pointObj, $movingFrequencyObj);
$movingObj->exec();


?>