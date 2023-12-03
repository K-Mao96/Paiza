<?php

/**
 * piza「Aランクレベルアップメニュー」
 * 座標系での向きの変わる移動
 * STEP: 2 座標系での移動・方角
 * @link https://paiza.jp/works/mondai/a_rank_level_up_problems/a_rank_snake_move_step2/edit?language_uid=php
 */

// 標準入力から、Y座標、X座標、移動の回数を取得する
[$startY, $startX, $n] = fscanf(STDIN, "%d %d %d");

// 移動後のY,X座標（初期値はスタート地点と同値）
$endY = $startY;
$endX = $startX;

// ==移動の回数繰り返す
for ($i=0; $i<$n; $i++) {
    // 標準入力から、移動の方向を取得する
    fscanf(STDIN, "%s", $direction);

    switch ($direction) {

    // NならY座標を-1
    case "N":
        $endY --;
        break;

    // SならY座標を+1
    case "S":
        $endY ++;
        break;

    // EならX座標を+1
    case "E":
        $endX ++;
        break;

    // WならX座標を-1
    case "W":
        $endX --;
        break;

    }

    // 現在地の座標を出力する
    echo $endY;
    echo " ";
    echo $endX;
    echo "\n";
    

}





?>