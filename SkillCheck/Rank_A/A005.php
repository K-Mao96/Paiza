<?php

// 迷路クラス

use Player as GlobalPlayer;

class Meiro {
    public int $h;
    public int $w;
    public array $meiro;

    public function __construct(int $h, int $w)
    {
        $this->h = $h;
        $this->w = $w;

        for($i=1; $i<=$h; $i++) {
            fscanf(STDIN, "%s", $info);
            // 横
            $arrayInfo = str_split($info);
            $newIndexes = range(1, $w);
            $this->meiro[$i] = array_combine($newIndexes, $arrayInfo);
        }
    }

    public function drawMeiro() {
        return $this->meiro;
    }

}

// プレイヤークラス
class Player {
    // 初期位置
    public int $originalH;
    public int $originalW;
    // 現在位置
    public int $currentH;
    public int $currentW;
    // 初期位置から進める方向リスト
    public array $openDirections = [];
    // ゴールフラグ(true: ゴール)
    public bool $isClear = false;

    const DIRECTION = [
        'north', // 上
        'east',  // 右
        'south', // 下
        'west',  // 左
    ];

    public function __construct($meiro)
    {
        foreach ($meiro as $h => $row) {
            $w = array_search('S', $row);
            if ($w) {
                $this->originalH = $this->currentH = $h;
                $this->originalW = $this->currentW = $w;
            }
        }

    }

    // 迷路を進む
    public function goUp($meiro) {
        // 上に進む
        if ($meiro[$this->currentH-1][$this->currentW] === '#') {
            return;
        } else {
            $this->currentH --;
        }
        
    }

}

// H（縦）とW（横）を取得
fscanf(STDIN, "%d %d", $H, $W);
$meiroObj = new Meiro($H, $W);
$meiro = $meiroObj->drawMeiro();

$player = new Player($meiro);
var_dump($player->originalH);
var_dump($player->originalW);
var_dump($player->currentH);
var_dump($player->currentW);



