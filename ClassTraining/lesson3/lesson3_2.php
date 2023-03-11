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
    }

    //イベントクラス
    class Event {

        //全ての勇者の情報を持つ配列
        public static array $braves = [];

        //勇者の情報をセットする
        public static function setBrave(int $braveId, Brave $brave)
        {
            self::$braves[$braveId] = $brave;
        }

        //levelup h a d s c f
        public static function levelUp(
            int $braveId,
            int $physicalStrength,
            int $offensivePower,
            int $defense,
            int $agility,
            int $cleverness,
            int $luck
            )
        {
            $brave = self::$braves[$braveId];
            $brave->levelUp();
            $brave->physicalStrengthUP($physicalStrength);
            $brave->offensivePowerUp($offensivePower);
            $brave->defenseUp($defense);
            $brave->agilityUp($agility);
            $brave->clevernessUp($cleverness);
            $brave->luckUp($luck);
        }

        //muscle_training h a
        public static function muscleTraining(int $braveId, int $physicalStrength, int $offensivePower) {
            self::$braves[$braveId]->physicalStrengthUP($physicalStrength);
            self::$braves[$braveId]->offensivePowerUp($offensivePower);
        }

        //running d s
        public static function running(int $braveId, int $defense, int $agility) {
            self::$braves[$braveId]->defenseUp($defense);
            self::$braves[$braveId]->agilityUp($agility);
        }

        //study c
        public static function study(int $braveId, int $cleverness) {
            self::$braves[$braveId]->clevernessUp($cleverness);
        }

        //pray f
        public static function pray(int $braveId, int $luck) {
            self::$braves[$braveId]->luckUp($luck);
        }
        
    }

    //勇者の人数、起こるイベントの回数を取得する
    fscanf(STDIN, "%d %d", $braveCount, $eventCount);

    //全ての勇者をインスタンス化する
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
        Event::setBrave($braveId, $brave);
        
    }

    //イベントの処理を行う
    for ($i = 1; $i <= $eventCount; $i ++) {

        $input = trim(fgets(STDIN));
        $arrayInput = explode(" ", $input);
        $braveId = $arrayInput[0];
        $event = $arrayInput[1];
        
        switch ($event) {
            case 'levelup':
                $physicalStrength = $arrayInput[2];
                $offensivePower = $arrayInput[3];
                $defense = $arrayInput[4];
                $agility = $arrayInput[5];
                $cleverness = $arrayInput[6];
                $luck = $arrayInput[7];
                Event::levelUp($braveId,$physicalStrength, $offensivePower, $defense, $agility, $cleverness, $luck);
                break;

            case 'muscle_training':
                $physicalStrength = $arrayInput[2];
                $offensivePower = $arrayInput[3];
                Event::muscleTraining($braveId, $physicalStrength, $offensivePower);
                break;

            case 'running':
                $defense = $arrayInput[2];
                $agility = $arrayInput[3];
                Event::running($braveId, $defense, $agility);
                break;

            case 'study':
                $cleverness = $arrayInput[2];
                Event::study($braveId, $cleverness);
                break;
            case 'pray':
                $luck = $arrayInput[2];
                Event::pray($braveId, $luck);
                break;
        }

    }

    //全ての勇者のステータスを出力する
    foreach(Event::$braves as $braveId => $brave) {
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