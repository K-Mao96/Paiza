<?php

    /**
     * スーパーカークラス
     */
    class SuperCar {
        
        /**
         * コンストラクタ
         */
        public function __construct(
            protected int $fuel,              //燃料
            protected int $fuelConsumption,   //燃費
            protected int $totalMileage = 0, //総移動距離
        ) {}
        
        /**
         * run機能
         *
         * @return void
         */
        public function run(): void {
            if ($this->fuel <= 0) {
                return;
            }

            //燃料を1消費し、f(km)走る
            $this->fuel -= 1;
            $this->totalMileage += $this->fuelConsumption;
        }
        
        /**
         * 総移動距離を返す
         *
         * @return integer
         */
        public function getTotalMileage(): int {
            return $this->totalMileage;
        }
    }
    
    /**
     * スーパースーパーカークラス
     */
    class SuperSuperCar extends SuperCar {
        /**
         * fly機能
         *
         * @return void
         */
        public function fly (): void {
            if ($this->fuel >= 5) {
                //燃料を5消費し、f^2(km)飛行する
                $this->fuel -= 5;
                $mileage = $this->fuelConsumption ** 2;
                $this->totalMileage += $mileage;
            } else {
                parent::run();
            }
        }
    }
    
    /**
     * スーパースーパースーパーカークラス
     */
    class SuperSuperSuperCar extends SuperCar {
        /**
         * fly機能
         *
         * @return void
         */
        public function fly (): void {
            if ($this->fuel >= 5) {
                //燃料を5消費し、2*f^2(km)飛行する
                $this->fuel -= 5;
                $mileage = 2 * $this->fuelConsumption ** 2;
                $this->totalMileage += $mileage;
            } else {
                parent::run();
            }
        }

        /**
         * teleport機能
         *
         * @return void
         */
        public function teleport(): void {
            $cost = $this->fuelConsumption ** 2;
            if ($this->fuel >= $cost) {
                $this->fuel -= $cost;
                
                $mileage = $this->fuelConsumption ** 4;
                $this->totalMileage += $mileage;
            } else {
                $this->fly();
            }
        }
    }
    
    //車の総数、機能を使う回数を取得
    fscanf(STDIN, "%d %d", $carCount, $functionCount);
    
    //全ての車をインスタンス化する
    //車を管理する配列
    $cars = [];
    for ($carId = 1; $carId <= $carCount; $carId ++) {
        fscanf(STDIN, "%s %d %d", $carType, $fuel, $fuelConsumption);
        
        //車の種類に応じてインスタンス化する
        switch ($carType) {
            case 'supercar':
                $cars[$carId] = new SuperCar($fuel, $fuelConsumption);
                break;
            case 'supersupercar':
                $cars[$carId] = new SuperSuperCar($fuel, $fuelConsumption);
                break;
            case 'supersupersupercar':
                $cars[$carId] = new SuperSuperSuperCar($fuel, $fuelConsumption);
                break;
            default:
                break;
        }
        
    }
    
    //車の機能を使う
    for ($i = 1; $i <= $functionCount; $i ++) {
        fscanf(STDIN, "%d %s", $carId, $function);
        
        $car = $cars[$carId];
        
        switch ($function) {
            case 'run':
                $car->run();
                break;
            case 'fly':
                $car->fly();
                break;
            case 'teleport':
                $car->teleport();
                break;
            default:
                break;
        }
    }
    
    
    //全ての車の総移動距離を出力する
    foreach ($cars as $car) {
        $totalMileage = $car->getTotalMileage();
        echo $totalMileage . "\n";
    }

    
    
?>