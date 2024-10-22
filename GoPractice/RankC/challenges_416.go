// クリア済み
package main
import "fmt"
import "strings"

// 文字が母音かどうかチェックする関数
func isVowel(char rune) bool {
	// 母音のセット（大文字と小文字）
	vowels := "aeiouAEIOU"
	// 母音のセットに含まれているかチェック
	return strings.ContainsRune(vowels, char)
}

func main(){
    
    // 標準入力からターゲット文字列を取得
    var targetText string
    fmt.Scan(&targetText)
    
    // 回答の文字列を定義
    var answerText string
    
    // ターゲット文字列の文字のうち子音だけをつなげて回答を生成
    for _, targetChar := range targetText {
        if !isVowel(targetChar) {
            answerText += string(targetChar)
        }
    }
    // 回答を出力
    fmt.Println(answerText)
}
