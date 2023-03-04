<?php

    class Maiz {
        
        //道の種類
        public const ROOT_TYPE_1 = 1;
        public const ROOT_TYPE_2 = 2;
        
        //全ての地点の情報
        private $positions = [];
        //呪文
        private string $incantation = '';
        
        //コンストラクタ
        //現在地を初期化する
        public function __construct(private int $currentPosition) 
        {}
        
        //全ての地点の情報をセットする
        public function setPositions(int $positionNum, string $alphabet, int $direction1, int $direction2): void {
            $positionInfo = [
                 'alphabet'   => $alphabet,
                 self::ROOT_TYPE_1 => $direction1,
                 self::ROOT_TYPE_2 => $direction2,
            ];
         
            $this->positions[$positionNum] = $positionInfo;
        }
        
        //現在地を取得する
        public function getCurrentPosition(): int {
            return $this->currentPosition;
        }
        
        //選択した道の行き先を取得する
        public function getNextPosition(int $selectedRoot) {
            $nextPosition = $this->positions[$this->currentPosition][$selectedRoot];
            return $nextPosition;
        }
        
        //道を進める
        public function updatePosition(int $nextPosition): void {
            $this->currentPosition = $nextPosition;
        }
        
        //呪文をつなげる
        public function makeIncantation(int $currentPosition): void {
            $this->incantation .= $this->positions[$currentPosition]['alphabet'];
        }
        
        //呪文を唱える
        public function getIncantation(): string {
            return $this->incantation;
        }
    }
    
   
    //地点の数, 移動の回数, 現在地を取得
    fscanf(STDIN, "%d %d %d", $positionCount, $moveCount, $currentPosition);
    
    //迷路をインスタンス化する
    $maiz = new Maiz($currentPosition);

    //全ての地点の情報を取得する
    for ($positionNum = 1; $positionNum <= $positionCount; $positionNum ++) {
         //地点のアルファベット、 道1の行き先、道2の行き先を取得する
         fscanf(STDIN, "%s %d %d", $alphabet, $direction1, $direction2);
         $maiz->setPositions($positionNum, $alphabet, $direction1, $direction2);
    }

    
    //移動の数だけ繰り返す（スタート地点からなので、0から始める）
    for ($k = 0; $k <= $moveCount; $k ++) {
        //現在地を取得する
        $currentPosition = $maiz->getCurrentPosition();
        //現在地のアルファベットを、呪文の変数に文字列結合する
        $maiz->makeIncantation($currentPosition);
        
        //ゴールに到着していない場合は、次の地点に進む
        if ($k < $moveCount) {
            //選択した道の番号を取得する
            fscanf(STDIN, "%d", $selectedRoot);
            //次の地点を求める
            $nextPosition = $maiz->getNextPosition($selectedRoot);
            //現在地を移動する
            $maiz->updatePosition($nextPosition);
        }
    }
    

    //呪文と改行を出力する
    echo $maiz->getIncantation() . "\n";
     
?>