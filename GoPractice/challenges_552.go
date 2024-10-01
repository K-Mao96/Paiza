package main

import "fmt"

func main() {
    
    // 標準入力を取得
    var n int
    fmt.Scan(&n)
    
    // 1年の日数を定義
    days := 365
    
    // 計算する
    total := n * days
    
    // 結果を出力する
    fmt.Println(total)
}