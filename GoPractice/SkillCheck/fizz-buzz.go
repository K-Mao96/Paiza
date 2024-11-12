package main

import "fmt"

func main() {
    
    // 標準入力を取得
    var inputNum int
    fmt.Scan(&inputNum)

    fizzString := "Fizz"
    buzzString := "Buzz"
    fizzBuzzString := fizzString + " " + buzzString
    
    for i := 1; i <= inputNum; i++ {
        switch {
            case i%3 == 0 && i%5 == 0:
                fmt.Println(fizzBuzzString)
            case i%3 == 0:
                fmt.Println(fizzString)
            case i%5 == 0:
                fmt.Println(buzzString)
            default:
                fmt.Println(i)
        }
    }
}