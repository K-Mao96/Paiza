<?php

    //勇者クラス
    class Brave {

        //コンストラクタ
        //ステータスの初期値をセットする
        public function __construct(
            private int $level,            //レベル
            private int $physicalStrength, //体力
            private int $offensivePower,   //攻撃力
            private int $defense,          //防御力
            private int $agility,          //素早さ
            private int $cleverness,       //賢さ
            private int $luck              //運
        ) {}

        //レベルをアップする
        public function levelUp($value = 1) {
            $this->level += $value;
        }

        //体力をアップする
        public function physicalStrengthUP($value) {
            $this->physicalStrength += $value;
        }

        //攻撃力をアップする
        public function offensivePowerUp($value) {
            $this->offensivePower += $value;
        }

        //防御力をアップする
        public function defenseUp($value) {
            $this->defense += $value;
        }

        //素早さをアップする
        public function agilityUp($value) {
            $this->agility += $value;
        }

        //賢さをアップする
        public function clevernessUp($value) {
            $this->cleverness += $value;
        }

        //運をアップする
        public function luckUp ($value) {
            $this->luck += $value;
        }

        //レベルを返す
        public function getLevel() {
            return $this->level;
        }
        //体力を返す
        public function getphysicalStrength() {
            return $this->physicalStrength;
        }
        //攻撃力を返す
        public function getOffensivePower() {
            return $this->offensivePower;
        }
        //防御力を返す
        public function getDefense() {
            return $this->defense;
        }
        //素早さを返す
        public function getAgility() {
            return $this->agility;
        }
        //賢さを返す
        public function getCleverness() {
            return $this->cleverness;
        }
        //運を返す
        public function getLuck() {
            return $this->luck;
        }

        //levelup h a d s c f
        public function levelUpEvent(
            int $physicalStrength,
            int $offensivePower,
            int $defense,
            int $agility,
            int $cleverness,
            int $luck
            )
        {
            $this->levelUp();
            $this->physicalStrengthUP($physicalStrength);
            $this->offensivePowerUp($offensivePower);
            $this->defenseUp($defense);
            $this->agilityUp($agility);
            $this->clevernessUp($cleverness);
            $this->luckUp($luck);
        }

        //muscle_training h a
        public function muscleTrainingEvent(int $physicalStrength, int $offensivePower) {
            $this->physicalStrengthUP($physicalStrength);
            $this->offensivePowerUp($offensivePower);
        }

        //running d s
        public function runningEvent(int $defense, int $agility) {
            $this->defenseUp($defense);
            $this->agilityUp($agility);
        }

        //study c
        public function studyEvent(int $cleverness) {
            $this->clevernessUp($cleverness);
        }

        //pray f
        public function prayEvent(int $luck) {
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

        $input = trim(fgets(STDIN));
        $arrayInput = explode(" ", $input);
        $braveId = $arrayInput[0];
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