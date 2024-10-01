package main

import "fmt"

func main() {
    // 標準入力を取得する
    var distanceMeter int
	fmt.Scanf("%d", &distanceMeter)
	
	// 進む速さ（分速）を定義
	speedMeterMinute := 80
	
	// 移動にかかる時間を計算
	costMinute := distanceMeter / speedMeterMinute
	
	fmt.Println(costMinute)
	
}