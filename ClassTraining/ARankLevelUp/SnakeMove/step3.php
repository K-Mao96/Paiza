<?php

use Direction as GlobalDirection;

/**
 * piza「Aランクレベルアップメニュー」
 * 座標系での向きの変わる移動
 * STEP: 3 座標系での移動・向き
 * @link https://paiza.jp/works/mondai/a_rank_level_up_problems/a_rank_snake_move_step3/edit?language_uid=php
 */

class CoordinateException extends Exception {}
class FacingException extends Exception {}
class DirectionException extends Exception {}

// 現在地クラス
class Point
 {
    // y座標
    private int $y;
    // x座標
    private int $x;

    public function __construct(int $y, int $x)
    {
        if ($y < -100 || $x < -100) {
            throw new CoordinateException("座標には-100以上を指定してください");
        }
        if ($y > 100 || $x > 100) {
            throw new CoordinateException("座標には100以下を指定してください");
        }

        $this->y = $y;
        $this->x = $x;
    }

    // 現在地を移動する
    public function move(int $diffY, int $diffX): void
    {

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

// 方角クラス
class Facing
{
    // 方角のリスト
    const NORTH = "N";
    const SOUTH = "S";
    const EAST  = "E";
    const WEST  = "W";

    private string $value;

    public function __construct(string $facing)
    {
        if ($facing !== self::NORTH && $facing !== self::SOUTH && $facing !== self::EAST && $facing !== self::WEST) {
            // TODO: 例外の名称を変更する
            throw new FacingException("方角にはN、S、E、Wのいずれかを指定してください。");
        }

        $this->value = $facing;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

// 進行方向クラス
class Direction
{
    const RIGHT = 'R';
    const LEFT  = 'L';

    private string $value;

    public function __construct(string $direction)
    {
        if ($direction !== self::RIGHT && $direction !== self::LEFT) {
            throw new DirectionException("進行方向にはRかLを指定してください。");
        }

        $this->value = $direction;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

// 移動を実行するクラス
class Moving
{
    // 現在地
    private Point $pointObj;

    // 方角
    private Facing $facingObj;

    // 進行方向
    private Direction $directionObj;

    // x座標の差分
    private int $diffX;

    // y座標の差分
    private int $diffY;

    public function __construct(Point $pointObj, Facing $facingObj, Direction $directionObj)
    {
        $this->pointObj     = $pointObj;
        $this->facingObj    = $facingObj;
        $this->directionObj = $directionObj;
        $this->diffX        = 0;
        $this->diffY        = 0;
    }

    // 差分を計算する
    public function calcDiff(): void
    {
        // 方角
        $facing = $this->facingObj->getValue();
        // 進行方向
        $direction = $this->directionObj->getValue();

        // 移動距離
        // MEMO: 左へ進むことを1とすれば、右へ進むことは-1と表現できる
        if ($direction === Direction::RIGHT) {
            $distance = -1;
        }
        if ($direction === Direction::LEFT) {
            $distance = 1;
        }

        switch ($facing) {
            case Facing::SOUTH :
                $this->diffX += $distance;
                break;
            case Facing::WEST :
                $this->diffY += $distance;
                break;
            case Facing::EAST :
                $this->diffY -= $distance;
                break;
            case Facing::NORTH :
                $this->diffX -= $distance;
                break;
        }

    }

    public function exec(): void
    {
        // 差分を計算
        $this->calcDiff();
        // 差分だけ移動する
        $this->pointObj->move($this->diffY, $this->diffX);
        // 移動後の座標を出力する
        $this->pointObj->echoPoint();

    }
}


// 標準入力から、Y座標、X座標、移動の回数を取得する
[$startY, $startX, $facing] = fscanf(STDIN, "%d %d %s");

[$direction] = fscanf(STDIN, "%s");

// 現在地
$pointObj = new Point($startY, $startX);

// 向いている方角
$facingObj = new Facing($facing);

// 進行方向
$directionObj = new Direction($direction);

// 移動する
$movingObj = new Moving($pointObj, $facingObj, $directionObj);
$movingObj->exec();


?>