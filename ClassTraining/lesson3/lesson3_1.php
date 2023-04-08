<?php

/**
 * piza「クラス・構造体メニュー」
 * ロボットの暴走
 * STEP: 1 出口のない迷路
 * @link https://paiza.jp/works/mondai/class_primer/class_primer__closed_maze/edit?language_uid=php
 */

    /**
     * 地点クラス
     */
    class Position {
        /**
         * 1つの地点から延びている道の種類
         */
        private const ROOT_TYPE_1 = 1;
        private const ROOT_TYPE_2 = 2;

        /**
         * 地点のアルファベット
         * 
         * @var string
         */
        private string $alphabet;

        /**
         * 道1の行き先地点番号
         *
         * @var integer
         */
        private int $direction1;

        /**
         * 道2の行き先地点番号
         *
         * @var integer
         */
        private int $direction2;
        

        /**
         * コンストラクタ
         *
         * @param string  $alphabet   地点のアルファベット
         * @param integer $direction1 道1の行き先地点番号
         * @param integer $direction2 道2の行き先地点番号
         */
        public function __construct(string $alphabet, int $direction1, int $direction2)
        {
            $this->alphabet   = $alphabet;
            $this->direction1 = $direction1;
            $this->direction2 = $direction2;
        }

        /**
         * 地点のアルファベットを取得する
         *
         * @return string
         */
        public function getAlphabet(): string {
            return $this->alphabet;
        }

        /**
         * 道の行き先を取得する
         *
         * @param integer $rootType 選択された道の種類
         * @return integer
         */
        public function getDirection(int $rootType): int {

            switch ($rootType) {
                case self::ROOT_TYPE_1:
                    $direction = $this->direction1;
                    break;
                case self::ROOT_TYPE_2:
                    $direction = $this->direction2;
                    break;
                default:
                    break;
            }

            return $direction;
        }


    }


    /**
     * 迷路クラス
     */
    class Maze {

        /**
         * 全ての地点の情報
         *
         * @var array
         */
        private array $positions = [];

        /**
         * 呪文
         *
         * @var string
         */
        private string $incantation = '';
        

        /**
         * コンストラクタ
         *
         * 現在地を初期化する
         * @param integer $currentPosition 現在地
         */
        public function __construct(private int $currentPosition) 
        {}

        /**
         * 全ての地点の情報をセットする
         *
         * @param integer  $positionNum 地点番号
         * @param Position $position    地点の情報
         * @return void
         */
        public function setPosition(int $positionNum, Position $position): void {
            $this->positions[$positionNum] = $position;
        }
        
        /**
         * 現在地を取得する
         *
         * @return integer
         */
        public function getCurrentPosition(): int {
            return $this->currentPosition;
        }

        /**
         * 選択した道の行き先を取得する
         *
         * @param  integer $rootType 選択した道の番号
         * @return integer
         */
        public function getNextPosition(int $rootType): int {
            return $this->positions[$this->currentPosition]->getDirection($rootType);
        }

        /**
         * 道を進める
         *
         * @param integer $nextPosition 次の行き先となる地点の番号
         * @return void
         */
        public function updatePosition(int $nextPosition): void {
            $this->currentPosition = $nextPosition;
        }

        /**
         * 現在地のアルファベットを呪文に追加する
         *
         * @return void
         */
        public function addAlphabetToIncantation(): void {
            $this->incantation .= $this->positions[$this->currentPosition]->getAlphabet();
        }

        /**
         * 呪文を唱える
         *
         * @return string
         */
        public function getIncantation(): string {
            return $this->incantation;
        }
    }
    
   
    //地点の数, 移動の回数, 現在地を取得
    fscanf(STDIN, "%d %d %d", $positionCount, $moveCount, $currentPosition);
    
    //迷路をインスタンス化する
    $maze = new Maze($currentPosition);

    //全ての地点の情報を取得する
    for ($positionNum = 1; $positionNum <= $positionCount; $positionNum ++) {
         //地点のアルファベット、 道1の行き先、道2の行き先を取得する
         fscanf(STDIN, "%s %d %d", $alphabet, $direction1, $direction2);
         $position = new Position($alphabet, $direction1, $direction2);
         $maze->setPosition($positionNum, $position);
    }


    
    //移動の数だけ繰り返す（スタート地点からなので、0から始める）
    for ($k = 0; $k <= $moveCount; $k ++) {
        //現在地のアルファベットを、呪文の変数に文字列結合する
        $maze->addAlphabetToIncantation();
        
        //ゴールに到着していない場合は、次の地点に進む
        if ($k < $moveCount) {
            //選択した道の番号を取得する
            fscanf(STDIN, "%d", $rootType);
            //次の地点を求める
            $nextPosition = $maze->getNextPosition($rootType);
            //現在地を移動する
            $maze->updatePosition($nextPosition);
        }
    }

    //呪文と改行を出力する
    echo $maze->getIncantation() . "\n";
     
?>