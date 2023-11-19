<?php

use Text as GlobalText;
use XCoordinate as GlobalXCoordinate;

/**
 * piza「Aランクレベルアップメニュー」
 * 座標系での向きの変わる移動
 * STEP: 1 マップからの座標取得
 * @link https://paiza.jp/works/mondai/a_rank_level_up_problems/a_rank_snake_move_step1/edit?language_uid=php
 */

class RowAmoutException extends Exception {}
class ColAmoutException extends Exception {}
class TextAmoutException extends Exception {}
class CoordinateAmountException extends Exception {}
class YCoordinateException extends Exception {}
class XCoordinateException extends Exception {}

// 盤面の行数クラス
    // 1<=H<=20
class Row {
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 1) {
            throw new RowAmoutException("行数には1以上を指定してください");
        }
        if ($value > 20) {
            throw new RowAmoutException("行数には20以下を指定してください");
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

// 盤面の列数クラス
    //1<=W<=20
class Col {
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 1) {
            throw new ColAmoutException("列数には1以上を指定してください");
        }
        if ($value > 20) {
            throw new ColAmoutException("列数には20以下を指定してください");
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

// 盤面の文字列クラス
    // .か#
class Text {
    private string $value;

    final public const DOT   = ".";
    final public const SHARP = "#";

    public function __construct(string $value)
    {
        if ($value !== self::DOT && $value !== self::SHARP) {
            throw new TextAmoutException("盤面の文字には" . self::DOT . "か" . self::SHARP . "のみを指定してください。");
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

// 盤面クラス
    // 盤面２次元配列で表現する
class Board {
    private array $board;

    public function __construct(Row $row)
    {
        $row = $row->getValue();

        for ($i=0; $i<$row; $i++) {
            // 各行の文字列を取得する
            fscanf(STDIN, "%s", $text);
        
            // 1文字ずつ区切って配列にする
            $textListTmp = str_split($text);

            // 文字はTextオブジェクトとして扱う
            $textList = array_map(function ($text) {
                return new Text($text);
            }, $textListTmp);
        
            $this->board[$i] = $textList;
        }
    }

    public function getBoard(): array
    {
        return $this->board;
    }

    // 指定された座標に書かれた文字を返す
    public function getBoardText(XCoordinate $x, YCoordinate $y): Text
    {
        $xValue = $x->getValue();
        $yValue = $y->getValue();

        $text = $this->board[$yValue][$xValue];

        return $text;
    }
}

// 座標の数クラス
    // 1<=N<=H*W
// class CoordinateAmount {
//     private int $value;

//     public function __construct(int $value, Row $row, Col $col)
//     {
//         $height    = $row->getValue();
//         $width     = $col->getValue();
//         $maxAmount = $height * $width;

//         if ($value < 1) {
//             throw new CoordinateAmountException("座標の数には1以上を指定してください。");
//         }

//         if ($value > $maxAmount) {
//             throw new CoordinateAmountException("座標の数には" . $maxAmount . "以下を指定してください。");
//         }

//         $this->value = $value;
//     }

//     public function getValue(): int
//     {
//         return $this->value;
//     }
// }

// Y座標クラス
    // 0 ≦ y < H
class YCoordinate {
    private int $value;

    public function __construct(int $value, Row $row)
    {
        $height = $row->getValue();

        if ($value < 0) {
            throw new YCoordinateException("y座標には0以上を指定してください。");
        }

        if ($value > $height) {
            throw new YCoordinateException("y座標には" . $height . "より小さい値を指定してください。");
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

// X座標クラス
    // 0 ≦ x < W 
class XCoordinate {
    private int $value;

    public function __construct(int $value, Col $col)
    {
        $width = $col->getValue();

        if ($value < 0) {
            throw new XCoordinateException("x座標には0以上を指定してください。");
        }

        if ($value > $width) {
            throw new XCoordinateException("x座標には" . $width . "より小さい値を指定してください。");
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

// 処理実行クラス
class searchTargetCoordinate
{
    private Row $rowObj;
    private Col $colObj;
    private Board $boardObj;
    private Text $targetText;

    public function __construct(Row $rowObj, Col $colObj, Board $boardObj)
    {
        $this->rowObj     = $rowObj;
        $this->colObj     = $colObj;
        $this->boardObj   = $boardObj;
        $this->targetText = new Text(Text::SHARP);
    }

    public function exec(): void
    {
        $board = $this->boardObj->getBoard();
        
        foreach ($board as $y => $textList) {

            $x = array_search($this->targetText, $textList);

            // MEMO: ターゲット文字は必ず1つ存在する必ずヒットするので、この条件式は不要ではある
            if (is_numeric($x)) {

                $targetXObj = new XCoordinate($x, $this->colObj);
                $targetYObj = new YCoordinate($y, $this->rowObj);
                $targetY = $targetYObj->getValue();
                $targetX = $targetXObj->getValue();

                echo $targetY . " " . $targetX . "\n";
            }
        }
    }

}


// 盤面の行数H、列数W、座標の数Nを取得する
[$h, $w, $n] = fscanf(STDIN, "%d %d %d");

// 盤面の行数
$rowObj = new Row($h);

// 盤面の列数
$colObj = new Col($w);

// 盤面
$boardObj = new Board($rowObj);

// ターゲット文字が書かれたマスの座標を出力する
$drawBoardTextObj = new searchTargetCoordinate($rowObj, $colObj, $boardObj);
$drawBoardTextObj->exec();
?>