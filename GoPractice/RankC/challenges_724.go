// レベルが高い方が勝つ
// 同じレベルなら引き分け

// 勝利：相手のレベルの半分だけレベルアップ
// 敗北：レベルが半分になる
// 引き分け：レベルの変動なし

package main

import "fmt"

func main() {
    
    // 入力を取得
    var fightNum, myLevel int 
    fmt.Scanf("%d %d", &fightNum, &myLevel)
    
    // n回の先頭を繰り返す
    for i := 0; i < fightNum; i++ {
        // 敵のレベルを取得
        var enemyLevel int
        fmt.Scan(&enemyLevel)
        
        // 同じレベルなら戦闘をスキップ
        if myLevel == enemyLevel {
            continue
        }
        
        // 勝利
        if myLevel > enemyLevel {
            addPoint := int(enemyLevel / 2)
            myLevel += addPoint
        } else {
            // 敗北
            myLevel /= 2
        }
    }
    fmt.Println(myLevel)
}