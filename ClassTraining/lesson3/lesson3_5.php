<?php
    // 工場クラス
    class Factory {
        // 工具箱の位置
        // 工具箱ID => ['x' => x座標, 'y' => y座標]
        public static array $toolBoxPoint = [];
    }
    
    // ロボットクラス
    class Robot {
        // 進めるマスの数
        // レベル => 進めるマスの数
        private const GRID = [
            1 => 1,
            2 => 2,
            3 => 5,
            4 => 10
        ];

        // レベルの最大値
        private const MAX_LEVEL = 4;
        
        // コンストラクタ
        public function __construct(
            private int  $pointX,                // x座標
            private int  $pointY,                // y座標
            private int  $level,                 // レベル
            private bool $isToolBoxPoint = false // ロボットの位置に工具があるかどうか
        ) {}
        
        // 移動する
        public function proceed (string $direction): void {
            // 進めるマスの数
            $grid = self::GRID[$this->level];
            
            switch ($direction) {
                case 'N':
                    // 北に進む：y座標を-の方向に進む
                    $this->pointY -= $grid;
                    break;
                case 'E':
                    // 東に進む：x座標を+の方向に進む
                    $this->pointX += $grid;
                    break;
                case 'S':
                    // 南に進む：y座標を+の方向に進む
                    $this->pointY += $grid;
                    break;
                case 'W':
                    // 西に進む：x座標を-の方向に進む
                    $this->pointX -= $grid;
                    break;
                
                default:
                    break;
            }
            
            // ロボットの位置に工具箱がある時は工具箱フラグをfalse → trueにする
            $this->checkToolBoxExistence();
            
            // 工具箱の位置で止まった場合はレベルアップする
            if ($this->isToolBoxPoint) {
                $this->levelUp();
            }
            
            // 工具箱フラグをリセットする
            $this->isToolBoxPoint = false;
        }
        
        // ロボットの位置に工具箱があるならフラグをtrueにする
        public function checkToolBoxExistence (): void {
            foreach (Factory::$toolBoxPoint as $point) {
                if ($this->pointX == $point['x'] && $this->pointY == $point['y']) {
                    $this->isToolBoxPoint = true;
                }
            }
        }
        
        // レベルアップする
        // 最大レベルは4
        public function levelUp(): void {
            if ($this->level < self::MAX_LEVEL) {
                $this->level ++;
            }
        }
        
        // x座標を返す
        public function getPointX(): int {
            return $this->pointX;
        }
        
        // y座標を返す
        public function getPointY(): int {
            return $this->pointY;
        }
        
        // レベルを返す
        public function getLevel(): int {
            return $this->level;
        }
        
        
        
    }
    
    // ロボットの初期位置のy座標の上限、x座標の上限、ロボットの数、ロボットの移動回数を取得する
    fscanf(STDIN, "%d %d %d %d", $maxY, $maxX, $totalRobot, $totalMove);
    
    // 工具箱の座標を取得する
    for ($i = 1; $i <= 10; $i++) {
        fscanf(STDIN, "%d %d", $toolBoxPointX, $toolBoxPointY);

        Factory::$toolBoxPoint[] = [
            'x' => $toolBoxPointX,
            'y' => $toolBoxPointY
        ];
    }
    
    // 全てのロボットのインスタンスを管理する配列
    $robots = [];
    // ロボットの数だけ繰り返す
    for ($robotId = 1; $robotId <= $totalRobot; $robotId ++) {
        // ロボットの初期位置のx座標、y座標、レベルを取得する
        fscanf(STDIN, "%d %d %d", $robotPointX, $robotPointY, $level);
        // ロボットをインスタンス化
        $robot = new Robot($robotPointX, $robotPointY, $level);
        $robots[$robotId] = $robot;
    }
    
    // 移動回数だけ繰り返す
    for ($i = 1; $i <= $totalMove; $i ++) {
        // 移動したロボットの番号、移動の方向を取得する
        fscanf(STDIN, "%d %s", $robotId, $direction);
        
        // 該当のロボットのインスタンスを取得
        $robot = $robots[$robotId];
        
        // ロボットの移動
        $robot->proceed($direction);
    }
    
    // 移動後のロボットの位置とレベルを出力する
    foreach ($robots as $robot) {
        // x座標を取得
        $pointX = $robot->getPointX();
        // y座標を取得
        $pointY = $robot->getPointY();
        // レベルを取得
        $level  = $robot->getLevel();

        // 出力する
        echo $pointX . " " . $pointY . " " . $level . "\n";
    }
?>