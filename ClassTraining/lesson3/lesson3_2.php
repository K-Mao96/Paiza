<?php
/**
 * piza「クラス・構造体メニュー」
 * ロボットの暴走
 * STEP: 2 RPG
 * @link https://paiza.jp/works/mondai/class_primer/class_primer__heros/edit?language_uid=php&t=059ab8da1b21929d4788f9ce3b033efa
 */


    /**
     * 勇者クラス
     */
    class Brave {

        /**
         * コンストラクタ
         *
         * 勇者のステータスに初期値をセットする
         * @param integer $level            レベル
         * @param integer $physicalStrength 体力
         * @param integer $offensivePower   攻撃力
         * @param integer $defense          防御力
         * @param integer $agility          素早さ
         * @param integer $cleverness       賢さ
         * @param integer $luck             運
         */
        public function __construct(
            private int $level,
            private int $physicalStrength,
            private int $offensivePower,
            private int $defense,
            private int $agility,
            private int $cleverness,
            private int $luck
        ) {}

        /**
         * 勇者のレベルをアップする
         *
         * @param integer $value レベルの増分
         * @return void
         */
        public function levelUp(int $value = 1): void {
            $this->level += $value;
        }

        /**
         * 勇者の体力をアップする
         *
         * @param integer $value 体力の増分
         * @return void
         */
        public function physicalStrengthUP(int $value): void {
            $this->physicalStrength += $value;
        }

        /**
         * 勇者の攻撃力をアップする
         *
         * @param integer $value 攻撃力の増分
         * @return void
         */
        public function offensivePowerUp(int $value): void {
            $this->offensivePower += $value;
        }

        /**
         * 勇者の防御力をアップする
         *
         * @param integer $value 防御力の増分
         * @return void
         */
        public function defenseUp(int $value): void {
            $this->defense += $value;
        }

        /**
         * 勇者の素早さをアップする
         *
         * @param integer $value 素早さの増分
         * @return void
         */
        public function agilityUp(int $value): void {
            $this->agility += $value;
        }

        /**
         * 勇者の賢さをアップする
         *
         * @param integer $value 賢さの増分
         * @return void
         */
        public function clevernessUp(int $value): void {
            $this->cleverness += $value;
        }

        /**
         * 勇者の運をアップする
         *
         * @param integer $value 運の増分
         * @return void
         */
        public function luckUp (int $value): void {
            $this->luck += $value;
        }

        /**
         * 勇者のレベルを取得する
         *
         * @return integer
         */
        public function getLevel(): int {
            return $this->level;
        }
        /**
         * 勇者の体力を取得する
         *
         * @return integer
         */
        public function getphysicalStrength(): int {
            return $this->physicalStrength;
        }
        /**
         * 勇者の攻撃力を取得する
         *
         * @return integer
         */
        public function getOffensivePower(): int {
            return $this->offensivePower;
        }
        /**
         * 勇者の防御力を取得する
         *
         * @return integer
         */
        public function getDefense(): int {
            return $this->defense;
        }
        /**
         * 勇者の素早さを取得する
         *
         * @return integer
         */
        public function getAgility(): int {
            return $this->agility;
        }
        /**
         * 勇者の賢さを取得する
         *
         * @return integer
         */
        public function getCleverness(): int {
            return $this->cleverness;
        }
        /**
         * 勇者の運を取得する
         *
         * @return integer
         */
        public function getLuck(): int {
            return $this->luck;
        }

        /**
         * levelupイベント
         * 
         * 勇者の全てのステータスをアップさせる（レベルの増分は1で固定）
         * @param integer $physicalStrength 体力の増分
         * @param integer $offensivePower   攻撃力の増分
         * @param integer $defense          防御力の増分
         * @param integer $agility          素早さの増分
         * @param integer $cleverness       賢さの増分
         * @param integer $luck             運の増分
         * @return void
         */
        public function levelUpEvent(
            int $physicalStrength,
            int $offensivePower,
            int $defense,
            int $agility,
            int $cleverness,
            int $luck
            ): void
        {
            $this->levelUp();
            $this->physicalStrengthUP($physicalStrength);
            $this->offensivePowerUp($offensivePower);
            $this->defenseUp($defense);
            $this->agilityUp($agility);
            $this->clevernessUp($cleverness);
            $this->luckUp($luck);
        }

        /**
         * muscle_trainingイベント
         * 
         * 勇者の体力、攻撃力をアップさせる
         * @param integer $physicalStrength 体力の増分
         * @param integer $offensivePower   攻撃力の増分
         * @return void
         */
        public function muscleTrainingEvent(int $physicalStrength, int $offensivePower): void {
            $this->physicalStrengthUP($physicalStrength);
            $this->offensivePowerUp($offensivePower);
        }

        /**
         * runningイベント
         *
         * 勇者の防御力、素早さをアップさせる
         * @param integer $defense 防御力の増分
         * @param integer $agility 素早さの増分
         * @return void
         */
        public function runningEvent(int $defense, int $agility): void {
            $this->defenseUp($defense);
            $this->agilityUp($agility);
        }

        /**
         * studyイベント
         *
         * 勇者の賢さをアップさせる
         * @param integer $cleverness 賢さの増分
         * @return void
         */
        public function studyEvent(int $cleverness): void {
            $this->clevernessUp($cleverness);
        }

        /**
         * prayイベント
         *
         * 勇者の運をアップさせる
         * @param integer $luck 運の増分
         * @return void
         */
        public function prayEvent(int $luck): void {
            $this->luckUp($luck);
        }
    }


    //勇者の人数、起こるイベントの回数を取得する
    fscanf(STDIN, "%d %d", $braveCount, $eventCount);

    //全ての勇者をインスタンス化する
    $braves = [];
    for ($braveId = 1; $braveId <= $braveCount; $braveId++) {
        fscanf(
                STDIN, 
                "%d %d %d %d %d %d %d", 
                $level,
                $physicalStrength,
                $offensivePower,
                $defense,
                $agility,
                $cleverness,
                $luck
        );

        $brave = new Brave(
                    $level,
                    $physicalStrength,
                    $offensivePower,
                    $defense,
                    $agility,
                    $cleverness,
                    $luck
                );
        $braves[$braveId] = $brave;
        
    }

    //イベントの処理を行う
    for ($i = 1; $i <= $eventCount; $i ++) {

        //入力を取得
        $input = trim(fgets(STDIN));
        //入力をスペース区切りで配列に変換
        $arrayInput = explode(" ", $input);
        //勇者番号を取得
        $braveId = $arrayInput[0];
        //イベントの種類を取得
        $event = $arrayInput[1];

        //該当の勇者インスタンス
        $brave = $braves[$braveId];
        
        switch ($event) {
            case 'levelup':
                $physicalStrength = $arrayInput[2];
                $offensivePower = $arrayInput[3];
                $defense = $arrayInput[4];
                $agility = $arrayInput[5];
                $cleverness = $arrayInput[6];
                $luck = $arrayInput[7];
                $brave->levelUpEvent($physicalStrength, $offensivePower, $defense, $agility, $cleverness, $luck);
                break;

            case 'muscle_training':
                $physicalStrength = $arrayInput[2];
                $offensivePower = $arrayInput[3];
                $brave->muscleTrainingEvent($physicalStrength, $offensivePower);
                break;

            case 'running':
                $defense = $arrayInput[2];
                $agility = $arrayInput[3];
                $brave->runningEvent($defense, $agility);
                break;

            case 'study':
                $cleverness = $arrayInput[2];
                $brave->studyEvent($cleverness);
                break;

            case 'pray':
                $luck = $arrayInput[2];
                $brave->prayEvent($luck);
                break;
        }

    }

    //全ての勇者のステータスを出力する
    foreach($braves as $braveId => $brave) {
        if ($braveId >= 2) {
            echo "\n";
        }
        echo $brave->getLevel() . " ";
        echo $brave->getphysicalStrength() . " ";
        echo $brave->getOffensivePower() . " ";
        echo $brave->getDefense() . " ";
        echo $brave->getAgility() . " ";
        echo $brave->getCleverness() . " ";
        echo $brave->getLuck();
    }
?>