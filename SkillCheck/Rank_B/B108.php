<?php

/**
 * B108:観覧車の稼働状況
 * https://paiza.jp/career/challenges/527/retry
 */

    /**
     * ゴンドラクラス
     */
    class Gondola {
        //ゴンドラの総数
        public static int $total;
        //待機中のゴンドラ
        public static int $waiting = 1;
        //ゴンドラの定員
        public int $capacity;
        //乗車人数
        public int $count = 0;
        
        //定員をセットする
        public function __construct($capacity) {
            $this->capacity = $capacity;
        }
        
        //ゴンドラに客を乗せる
        public function ride($riderNum) {
            //乗車人数を更新する
            $this->count += $riderNum;
        }
        
        //待機中のゴンドラ番号を更新する
        public function switchGondola() {
            self::$waiting ++;
            //ゴンドラ番号の最大値を超える場合は、リセットする
            if (self::$waiting > self::$total) {
                self::$waiting = 1;
            }
        }
    }
    
    class Group {
        //未乗車人数
        public int $unriderNum;
        
        //未乗車人数をセットする
        //最初はグループの人数
        public function __construct($memberNum) {
            $this->unriderNum = $memberNum;
        }
        
        //ゴンドラに乗る
        public function ride($riderNum) {
            $this->unriderNum -= $riderNum;
        }
    }
    
    //入力を取得する
    fscanf(STDIN, "%d %d", $totalGondola, $totalGroup);
    
    //ゴンドラの総数の情報をクラスに保存
    Gondola::$total = $totalGondola;
    
    //全てのゴンドラのインスタンスを作る
    //インスタンスを管理する配列を用意
    $gondolas = [];
    for ($i = 1; $i <= $totalGondola; $i++) {
        //ゴンドラの定員を取得する
        fscanf(STDIN, "%d", $capacity);
        //ゴンドラをインスタンス化
        $gondola = new Gondola($capacity);
        //インスタンスを配列に保存
        $gondolas[$i] = $gondola;
    }
    
    //全てのグループのインスタンスを作る
    //インスタンスを管理する配列を用意
    $groups = [];
    for ($i = 1; $i <= $totalGroup; $i++) {
        //グループの人数を取得する
        fscanf(STDIN, "%d", $memberNum);
        //グループをインスタンス化
        $group = new Group($memberNum);
        //インスタンスを配列に保存
        $groups[$i] = $group;
    }
    
    //グループごとに乗車処理を実行する
    foreach ($groups as $id => $group) {
        //未乗車人数が0になるまで繰り返す
        while ($group->unriderNum > 0) {
            //現在待機中のゴンドラのインスタンスを取得する
            $gondola = $gondolas[Gondola::$waiting];
            //ゴンドラに全員乗れる場合
            if ($gondola->capacity >= $group->unriderNum) {
                $rider = $group->unriderNum;
            } else {
                //ゴンドラに全員乗れない場合
                $rider = $gondola->capacity;
            }
            
            //ゴンドラに客を乗せる
            $gondola->ride($rider);
            $gondola->switchGondola();
            $group->ride($rider);
        }
    }
    
    //ゴンドラごとに乗車人数を出力する
    foreach ($gondolas as $gondola) {
        echo $gondola->count . "\n";
    }

?>