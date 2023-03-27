<?php
    // 工場クラス
    class Factory {
        // 工具箱の位置
        // 工具箱ID => ['x' => x座標, 'y' => y座標]
        private static array $toolBoxPoints = [];

        //工具箱の位置をセットする
        public static function setToolBoxPoints(int $pointX, int $pointY): void {
            self::$toolBoxPoints[] = [
                'x' => $pointX,
                'y' => $pointY
            ];
        }

        //工具箱の位置を返す
        public static function getToolBoxPoints(): array {
            return self::$toolBoxPoints;
        }
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

        // 進行方向のベクトル
        private const VECTOR = [
            'N' => ['x' =>  0, 'y' => -1],
            'E' => ['x' =>  1, 'y' =>  0],
            'S' => ['x' =>  0, 'y' =>  1],
            'W' => ['x' => -1, 'y' =>  0],
        ];

        // レベルの最大値
        private const MAX_LEVEL = 4;
        
        // コンストラクタ
        public function __construct(
            private int $pointX, // x座標
            private int $pointY, // y座標
            private int $level   // レベル
        ) {}
        
        // 移動する
        public function proceed (string $direction): void {
            // 進めるマスの数
            $grid = self::GRID[$this->level];

            // 進むベクトル
            $vectorX = self::VECTOR[$direction]['x'];
            $vectorY = self::VECTOR[$direction]['y'];

            $this->pointX += $vectorX * $grid;
            $this->pointY += $vectorY * $grid;
            
        }
        
        // レベルアップする
        public function levelUp(): void {
            // 最大レベルは4
            $this->level = min($this->level + 1, self::MAX_LEVEL);
        }

        // 座標を返す
        public function getPoint(): array {
            return ['x' => $this->pointX, 'y' => $this->pointY];
        }
        
        // レベルを返す
        public function getLevel(): int {
            return $this->level;
        }

    }
    
    // ロボットの初期位置のy座標の上限、x座標の上限、ロボットの数、ロボットの移動回数を取得する
    fscanf(STDIN, "%d %d %d %d", $maxY, $maxX, $totalRobot, $totalMove);
    
    // 工具箱の座標を取得し、セットする
    for ($i = 1; $i <= 10; $i++) {
        fscanf(STDIN, "%d %d", $toolBoxPointX, $toolBoxPointY);
        Factory::setToolBoxPoints($toolBoxPointX, $toolBoxPointY);
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

        // ロボットの位置を取得
        $point = $robot->getPoint();

        //工具箱の位置を全て取得
        $toolBoxPoints = Factory::getToolBoxPoints();

        // ロボットの位置が工具箱の位置と同じなら、レベルアップする
        if (in_array($point, $toolBoxPoints)) {
            $robot->levelUp();
        }
    }
    
    // 移動後のロボットの位置とレベルを出力する
    foreach ($robots as $robot) {
        // 座標を取得
        $point = $robot->getPoint();
        // レベルを取得
        $level  = $robot->getLevel();

        // 出力する
        echo $point['x'] . " " . $point['y'] . " " . $level . "\n";
    }
?>