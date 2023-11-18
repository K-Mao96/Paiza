<?php

/**
 * piza「Aランクレベルアップメニュー」
 * マップの判定・縦横
 * STEP: 1 マップの判定・横
 * @link https://paiza.jp/works/mondai/a_rank_level_up_problems/a_rank_snake_map_step3?language_uid=php
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

    public function __construct(string $value)
    {
        if ($value !== "." && $value !== "#") {
            throw new TextAmoutException("盤面の文字には.か#のみを指定してください。");
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

// 盤面クラス
    // 盤面を２次元配列で表現する
class Board {
    private array $board;
    private array $replaceCoordinatesList;

    // 置換後の文字
    const REPLACE_TEXT = "#";

    // 左右判定のターゲット文字
    const TARGET_TEXT = "#";

    public function __construct(Row $row)
    {
        $this->replaceCoordinatesList = [];

        $row = $row->getValue();

        for ($i=0; $i<$row; $i++) {
            // 各行の文字列を取得する
            fscanf(STDIN, "%s", $text);
        
            // 1文字ずつ区切って配列にする
            $textListTmp = str_split($text);

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

    // 盤面を描画する
    public function drawBoard()
    {
        foreach ($this->board as $rowNum => $textList) {
            foreach ($textList as $colNum => $text) {
                $coordinate = [$rowNum, $colNum];
                if (in_array($coordinate, $this->replaceCoordinatesList)) {
                    echo self::REPLACE_TEXT;
                } else {
                    echo $text->getValue();
                }
            }
            echo "\n";
        }
    }

    // 文字を置換する座標リストを作成する
    public function makeReplaceTargetsList(CoordinateAmount $coordinateAmountObj, Row $rowObj, Col $colObj)
     {
        $coordinateAmount = $coordinateAmountObj->getValue();

        $replaceCoordinatesList = [];

        for ($i=0; $i<$coordinateAmount; $i++) {
            
            // 指定された座標を取得する
            [$y, $x] = fscanf(STDIN, "%d %d");
            $yObj    = new YCoordinate($y, $rowObj);
            $xObj    = new XCoordinate($x, $colObj);

            $replaceCoordinatesList[] = [$yObj->getValue(), $xObj->getValue()];
        }

        $this->replaceCoordinatesList = $replaceCoordinatesList;
     }

     // マスの両端がターゲット文字かどうか判定する
     public function isSandwichedTarget(XCoordinate $xObj, YCoordinate $yObj, Col $colObj)
     {
        // 左端のマスの場合
        if ($this->isLeftEnd($xObj)) {
            if ($this->isTargetRight($xObj, $yObj)) {
                return true;
            }
            return false;
        }

        // 右端のマスの場合
        if ($this->isRightEnd($xObj, $colObj)) {
            if ($this->isTargetLeft($xObj, $yObj)) {
                return true;
            }
            return false;
        }

        // 端のマス以外の場合
        if ($this->isTargetLeft($xObj, $yObj) && $this->isTargetRight($xObj, $yObj)) {
            return true;
        }
        return false;
     }

     // 左端のマスかどうか判定する
     public function isLeftEnd(XCoordinate $xObj)
     {
        $x = $xObj->getValue();

        if ($x === 0) {
            return true;
        }

        return false;
     }

     // 右端のマスかどうか判定する
     public function isRightEnd(XCoordinate $xObj, Col $colObj)
     {
        $x = $xObj->getValue();
        $maxCol = $colObj->getValue();
        $maxXValue = $maxCol - 1;

        if ($x === $maxXValue) {
            return true;
        }

        return false;
     }

     // 左隣のマスに書かれた文字が#かどうか判断する
     public function isTargetLeft(XCoordinate $xObj, YCoordinate $yObj)
     {
        $x = $xObj->getValue();
        $y = $yObj->getValue();

        $leftX = $x - 1;

        $leftTextObj =  $this->board[$y][$leftX];
        $leftText = $leftTextObj->getValue();
        
        return $leftText === self::TARGET_TEXT;
     }

     // 右隣のマスに書かれた文字が#かどうか判断する
     public function isTargetRight(XCoordinate $xObj, YCoordinate $yObj)
     {
        $x = $xObj->getValue();
        $y = $yObj->getValue();

        $rightX = $x + 1;

        $rightTextObj =  $this->board[$y][$rightX];
        $rightText = $rightTextObj->getValue();
        
        return $rightText === self::TARGET_TEXT;
     }
}

// 座標の数クラス
    // 1<=N<=H*W
class CoordinateAmount {
    private int $value;

    public function __construct(int $value, Row $row, Col $col)
    {
        $height    = $row->getValue();
        $width     = $col->getValue();
        $maxAmount = $height * $width;

        if ($value < 1) {
            throw new CoordinateAmountException("座標の数には1以上を指定してください。");
        }

        if ($value > $maxAmount) {
            throw new CoordinateAmountException("座標の数には" . $maxAmount . "以下を指定してください。");
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

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
class GetSandwichedCoordinate
{
    private Row $rowObj;
    private Col $colObj;
    private Board $boardObj;

    public function __construct(Row $rowObj, Col $colObj, Board $boardObj)
    {
        $this->rowObj   = $rowObj;
        $this->colObj   = $colObj;
        $this->boardObj = $boardObj;
    }

    public function exec(): void
    {
        // ボードの各マスの両端が#なら座標を出力する
        $row = $this->rowObj->getValue();
        $col = $this->colObj->getValue();

        for ($y=0; $y<$row; $y++) {
            for ($x=0; $x<$col; $x++) {
                $yObj = new YCoordinate($y, $this->rowObj);
                $xObj = new XCoordinate($x, $this->colObj);

                if ($this->boardObj->isSandwichedTarget($xObj, $yObj, $this->colObj)){
                    echo $y . " " . $x . "\n";
                }
            }
        }

    }

}


// 盤面の行数H、列数Wを取得する
[$h, $w] = fscanf(STDIN, "%d %d");

// 盤面の行数
$rowObj = new Row($h);

// 盤面の列数
$colObj = new Col($w);

// 盤面
$boardObj = new Board($rowObj);

// 与えられる座標の総数
// $coordinateAmountObj = new CoordinateAmount($n, $rowObj, $colObj);
// $coordinateAmount = $coordinateAmountObj->getValue();

// ボードの文字を出力する
$getSandwichedCoordinateObj = new GetSandwichedCoordinate($rowObj, $colObj, $boardObj);
$getSandwichedCoordinateObj->exec();
?>