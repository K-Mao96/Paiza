<?php

    /**
     * 地点クラス
     */
    class Position {
        //道の種類
        public const ROOT_TYPE_1 = 1;
        public const ROOT_TYPE_2 = 2;

        //アルファベット
        private string $alphabet;

        //道1の行き先
        private int $direction1;

        //道2の行き先
        private int $direction2;
        

        //地点の情報をセットする
        public function __construct(string $alphabet, int $direction1, int $direction2)
        {
            $this->alphabet = $alphabet;
            $this->direction1 = $direction1;
            $this->direction2 = $direction2;
        }

        // アルファベットを取得する
        public function getAlphabet(): string {
            return $this->alphabet;
        }

        //道の行き先を取得する
        public function getDirection(int $selectedRoot): int {
            return $selectedRoot === self::ROOT_TYPE_1 ? $this->direction1 : $this->direction2;
        }


    }


    /**
     * 迷路クラス
     */
    class Maiz {

        // 全ての地点の情報
        private array $positions = [];

        //呪文
        private string $incantation = '';
        
        //コンストラクタ
        //現在地を初期化する
        public function __construct(private int $currentPosition) 
        {}

        // 全ての地点の情報をセットする
        public function setPosition(int $positionNum, Position $position): void {
            $this->positions[$positionNum] = $position;
        }
        
        //現在地を取得する
        public function getCurrentPosition(): int {
            return $this->currentPosition;
        }
        
        //選択した道の行き先を取得する
        public function getNextPosition(int $selectedRoot): int {
            return $this->positions[$this->currentPosition]->getDirection($selectedRoot);
        }
        
        //道を進める
        public function updatePosition(int $nextPosition): void {
            $this->currentPosition = $nextPosition;
        }
        
        // 現在地のアルファベットを呪文に追加する
        public function addAlphabetToIncantation(): void {
            $this->incantation .= $this->positions[$this->currentPosition]->getAlphabet();
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

    $positions = [];
    //全ての地点の情報を取得する
    for ($positionNum = 1; $positionNum <= $positionCount; $positionNum ++) {
         //地点のアルファベット、 道1の行き先、道2の行き先を取得する
         fscanf(STDIN, "%s %d %d", $alphabet, $direction1, $direction2);
         $position = new Position($alphabet, $direction1, $direction2);
         $maiz->setPosition($positionNum, $position);
    }


    
    //移動の数だけ繰り返す（スタート地点からなので、0から始める）
    for ($k = 0; $k <= $moveCount; $k ++) {
        //現在地を取得する
        $currentPosition = $maiz->getCurrentPosition();
        //現在地のアルファベットを、呪文の変数に文字列結合する
        $maiz->addAlphabetToIncantation($currentPosition);
        
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