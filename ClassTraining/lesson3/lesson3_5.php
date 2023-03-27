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
            private int  $pointX,                // x座標
            private int  $pointY,                // y座標
            private int  $level,                 // レベル
            private bool $isToolBoxPoint = false // ロボットの位置に工具があるかどうか
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
        // 最大レベルは4
        public function levelUp(): void {
            if ($this->level < self::MAX_LEVEL) {
                $this->level ++;
            }
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

        // ロボットの位置を取得
        $point = $robot->getPoint();

        // ロボットの位置が工具箱の位置と同じなら、レベルアップする
        if (in_array($point, Factory::$toolBoxPoint)) {
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