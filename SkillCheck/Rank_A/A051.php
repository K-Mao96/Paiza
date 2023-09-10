<?php

// ゲームクラス

class Game {
    // 板の行数
    public int $h;
    // 板の列数
    public int $w;
    // 板一式
    public array $board;

    // 得点
    public int $point = 0;

    public function __construct(int $h, int $w)
    {
        $this->h = $h;
        $this->w = $w;

        for($i=1; $i<=$h; $i++) {
            $row = str_replace(" ", "", fgets(STDIN));
            $row = trim($row);
            // 横
            $arrayInfo = str_split($row);
            $newIndexes = range(1, $w);
            $this->board[$i] = array_combine($newIndexes, $arrayInfo);
        }
    }

    // 板一式を返す
    public function drawBoard() {
        return $this->board;
    }

    // 最初の板一式を返す
    public function firstBoards() {
        return $this->board[1];
    }

    // 次の板一式を返す
    public function nextBoards(int $currentH, int $currentW) {
        $min = $currentW - 1;
        $max = $currentW + 1;

        $nextH = $currentH + 1;

        $nextBoard[] = $min > 0 ? $this->board[$nextH][$min] : 0;
        $nextBoard[] = $this->board[$nextH][$currentW];
        $nextBoard[] = $max <= $this->w ? $this->board[$nextH][$max] : 0;

        return $nextBoard;
    }

    // 板の最後の列かどうか
    public function isLastRow(int $currentH) {
        return $currentH === $this->h;
    }

    // 得点を加算する
    public function addPoint(int $point) {
        $this->point += $point;
    }

}


// H（縦）とW（横）を取得
fscanf(STDIN, "%d %d", $H, $W);

// 板一式を取得
$gameObj = new Game($H, $W);
$board = $gameObj->drawBoard();

// 最奥の板一式を取得
$firstBoards = $gameObj->firstBoards();

// 次の板一式を取得
for ($h=1; $h<$gameObj->h; $h++) {
    $nextBoards[$h] = [];
    foreach ($firstBoards as $col => $firstBoard) {
        $nextBoards[$h][] = $gameObj->nextBoards(1, $col);
    }
}

foreach ($firstBoards as $col => $firstBoard) {
    // 最初のボードの得点
    $gameObj->point = 0;
    $gameObj->addPoint($firstBoard);
    foreach ($nextBoards as $row => $nextBoard) {
        foreach ($nextBoard as $index => $nextPoint) {
            if ($col)
            foreach ($nextPoint as $point) {
                if ($point === 0) {
                    continue;
                }
                $gameObj->addPoint($point);
                break;
            }
            break;
        }
    }
var_dump($gameObj->point);
}




