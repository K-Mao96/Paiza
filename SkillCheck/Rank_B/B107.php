<?php
    
    /**
     * B107:カードシャッフル
     * https://paiza.jp/career/challenges/525/retry
     */
    //カードクラス
    class Card {
        
        //全てのカードを配列で管理する
        private array $cards = [];
        
        //配列にカードをセットする
        public function __construct($totalCard) {
            for ($i=1; $i<=$totalCard; $i++) {
                $this->cards[] = $i;
            }
        }
        
        //カードの情報を返す
        public function getCards(): array {
            return $this->cards;
        }
        
        
        //カードをグループごとに分ける
        public function divideCard(int $groupUnit): void {
            $this->cards = array_chunk($this->cards, $groupUnit);
        }
        
        //カードをシャッフルする
        public function shuffleCard(): void {
            $this->cards = array_reverse($this->cards);
            $this->cards = array_reduce($this->cards, 'array_merge', []);
        }
        
        
    }
    
    //カード総数, 1セットあたりの枚数, シャッフル回数を取得
    fscanf(STDIN, "%d %d %d", $totalCard, $groupUnit, $shuffleCount);
    
    //カードクラスをインスタンス化
    $card = new Card($totalCard);
    
    //カードをK回シャッフルする
    for ($k=1; $k<=$shuffleCount; $k++) {
        //カードを分ける
        $card->divideCard($groupUnit);
        //カードをシャッフルする
        $card->shuffleCard();
    }
    
    //シャッフルした結果を出力する
    $cards = $card->getCards();
    foreach ($cards as $card) {
        echo $card . "\n";
    }
    
?>