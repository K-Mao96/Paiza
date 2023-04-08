<?php
    /**
     * プレイヤークラス
     */
    class Player {
        /**
         * 一人あたりの技の数
         */
        private const MOVE_COUNT = 3;

        /**
         * HP
         *
         * @var integer
         */
        private int $hp;

        /**
         * 技
         *
         * @var array
         */
        private array $moves = [];

        /**
         * 退場フラグ
         *
         * @var boolean
         * true：退場済み
         */
        private bool $exitFlg = false;

        /**
         * コンストラクタ
         *
         * @param integer $hp      HP
         * @param integer $frame_1 技1の発生フレーム
         * @param integer $power_1 技1の攻撃力
         * @param integer $frame_2 技2の発生フレーム
         * @param integer $power_2 技2の攻撃力
         * @param integer $frame_3 技3の発生フレーム
         * @param integer $power_3 技3の攻撃力
         */
        public function __construct(
            int $hp,
            int $frame_1,
            int $power_1,
            int $frame_2,
            int $power_2,
            int $frame_3,
            int $power_3
            ) {
                $this->hp = $hp;

                $frames = [$frame_1, $frame_2, $frame_3];
                $powers = [$power_1, $power_2, $power_3];
                
                //技をインスタンス化する
                for ($moveId = 0; $moveId < self::MOVE_COUNT; $moveId++) {
                    $this->makeMove($moveId, $frames[$moveId], $powers[$moveId]);
                }
            
        }

        /**
         * 技をインスタンス化する
         *
         * @param integer $moveId $movesのキー
         * @param integer $frame  技の発生フレーム
         * @param integer $power  技の攻撃力
         * @return void
         */
        public function makeMove(int $moveId, int $frame, int $power): void {
            $moveId++;
            if ($frame == StrengthenMove::FRAME && $power == StrengthenMove::POWER) {
                $this->moves[$moveId] = new StrengthenMove($frame, $power);
            } else {
                $this->moves[$moveId] = new AttackMove($frame, $power);
            }
        }
        
        /**
         * 指定されたキーの技を取得する
         *
         * @param integer $moveId 技のキー
         * @return Move
         */
        public function getMove(int $moveId):Move {
            return $this->moves[$moveId];
        }
        
        /**
         * 退場フラグを取得する
         *
         * @return boolean
         */
        public function getExitFlg(): bool {
            return $this->exitFlg;
        }
        

        /**
         * 攻撃技を使って相手にダメージを与える
         *
         * @param integer $moveId 技のキー
         * @param Player $player  相手プレーヤー
         * @return void
         */
        public function attack(int $moveId, Player $player): void {
            $this->getMove($moveId)->attack($player);
        }

        /**
         * 強化技を使って自分の技を強化する
         *
         * @param integer $moveId 技のキー
         * @return void
         */
        public function strengthen(int $moveId): void {
            $this->getMove($moveId)->strengthen($this->moves);
        }

        /**
         * 相手の攻撃によってダメージを受ける
         *
         * @param integer $power 相手の技の攻撃力
         * @return void
         */
        public function damage (int $power): void {
            $this->hp -= $power;

            //hpが0になったら退場する
            if ($this->hp <= 0) {
                $this->exitFlg = true;
            }
        }
    }
    

    /**
     * 技クラス
     */
    class Move {

        /**
         * 発生フレーム
         *
         * @var integer
         */
        protected int $frame;

        /**
         * 技フレーム
         *
         * @var integer
         */
        protected int $power;
        
        /**
         * コンストラクタ
         *
         * @param integer $frame 技の発生フレーム
         * @param integer $power 技の攻撃力
         */
        public function __construct(int $frame, int $power) {
            $this->frame = $frame;
            $this->power = $power;
        }

        /**
         * 技の発生フレームを返す
         *
         * @return integer
         */
        public function getFrame(): int {
            return $this->frame;
        }
    }
    
    /**
     * 強化技クラス
     * 技クラスのサブクラス
     */
    class StrengthenMove extends Move {
        /**
         * 強化技の発生フレーム（固定値）
         */
        public const FRAME = 0;
        /**
         * 強化技の攻撃力（固定値）
         */
        public const POWER = 0;

        /**
         * 他の攻撃技に与える効果
         * 他の技の発生フレームを-3する
         * 他の技の攻撃力を+5する
         */
        public const EFFECT_FRAME = 3;
        public const EFFECT_POWER = 5;
        
        /**
         * 他の攻撃技を強化する
         *
         * @param array $moves プレイヤーが持っている技
         * @return void
         */
        public function strengthen(array $moves): void {
            foreach ($moves as $move) {
                if (get_class($move) == 'AttackMove') {
                    $move->strengthenFrame();
                    $move->strengthenPower();
                }
            }
            
        }
    }
    

    /**
     * 攻撃技クラス
     * 継承元：技クラス
     */
    class AttackMove extends Move {
        
        /**
         * 相手を攻撃する
         *
         * @param Player $player 相手プレイヤー
         * @return void
         */
        public function attack(Player $player): void {
            $player->damage($this->power);
        }

        /**
         * 発生フレームを強化する
         *
         * @return void
         */
        public function strengthenFrame(): void {
            //発生フレームの最小値は1
            if ($this->frame >= (StrengthenMove::EFFECT_FRAME + 1)) {
                $this->frame -= StrengthenMove::EFFECT_FRAME;
            }
        }

        /**
         * 攻撃力を強化する
         *
         * @return void
         */
        public function strengthenPower(): void {
            $this->power += StrengthenMove::EFFECT_POWER;
        }
    }
    
    //プレイヤー数、攻撃回数を取得する
    fscanf(STDIN, "%d %d", $playerCount, $attackCount);
    
    //プレイヤーを管理する配列
    $players = [];
    //すべてのプレイヤーをインスタンス化する
    for ($playerId = 1; $playerId <= $playerCount; $playerId ++) {
        //プレイヤーのHp、技1の発生フレーム、技１の攻撃力、技２の発生フレーム、技２の攻撃力、技３の発生フレーム、技３の攻撃力を取得する
        fscanf(STDIN, "%d %d %d %d %d %d %d", $hp, $frame_1, $power_1, $frame_2, $power_2, $frame_3, $power_3);

        $player = new Player($hp, $frame_1, $power_1, $frame_2, $power_2, $frame_3, $power_3);
        $players[$playerId] = $player;
    }
    
    //戦いの処理
    for ($i = 1; $i <= $attackCount; $i++) {
        //技を使ったプレイヤー番号、そのプレイヤーが選んだ技番号、対戦相手のプレイヤー番号、そのプレイヤーが選んだ技番号を取得する
        fscanf(STDIN, "%d %d %d %d", $playerId_1, $moveId_1, $playerId_2, $moveId_2);
        //一人目のプレイヤー
        $player_1 = $players[$playerId_1];
        //二人目のプレイヤー
        $player_2 = $players[$playerId_2];
        //プレイヤーのうち少なくとも片方が退場していたら処理を抜ける
        if ($player_1->getExitFlg() || $player_2->getExitFlg()) {
            continue;
        }
        
        //どちらも攻撃系の技を使った場合
        if (get_class($player_1->getMove($moveId_1)) == 'AttackMove' && get_class($player_2->getMove($moveId_2)) == 'AttackMove') {
            //フレームが短い方の技を発動する（フレームが同値なら何もしない）
            if ($player_1->getMove($moveId_1)->getFrame() < $player_2->getMove($moveId_2)->getFrame()) {
                if (get_class($player_1->getMove($moveId_1)) == 'AttackMove') {
                    $player_1->attack($moveId_1, $player_2);
                }
                
            } else {
                if (get_class($player_2->getMove($moveId_2)) == 'AttackMove') {
                    $player_2->attack($moveId_2, $player_1);
                }
            }
        
        //どちらも強化系の技を使った場合
        } elseif (get_class($player_1->getMove($moveId_1)) == 'StrengthenMove' && get_class($player_2->getMove($moveId_2)) == 'StrengthenMove') {
            $player_1->strengthen($moveId_1);
            $player_2->strengthen($moveId_2);

        //一人が攻撃技、もう一人が強化技を使った場合
        } elseif (get_class($player_1->getMove($moveId_1)) == 'StrengthenMove') {
            $player_1->strengthen($moveId_1);
            $player_2->attack($moveId_2, $player_1);
        } elseif (get_class($player_2->getMove($moveId_2)) == 'StrengthenMove') {
            $player_2->strengthen($moveId_2);
            $player_1->attack($moveId_1, $player_2);
        }
        
        
    }

    
    //全てのプレイヤーのうち、退場フラグがfalseのプレイヤーをカウントし、その数を出力する
    $survivorCount = 0;
    foreach ($players as $player) {
        $exitFlg = $player->getExitFlg();
        if (!$exitFlg) {
            $survivorCount++;
        }
    }
    
    echo $survivorCount;
    
?>