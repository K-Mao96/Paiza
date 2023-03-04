<?php

    //呪文を空文字列として定義
    $incantation = '';
    
    //現在地Sを取得
    fscanf(STDIN, "%d %d %d", $positionCount, $moveCount, $currentPosition); //N,K,S
    
    
    //地点の数Nを取得
    
    
    //各地点の情報を格納する配列
    $positions = [];
    //地点の数だけ繰り返す
    for ($positionNum = 1; $positionNum <= $positionCount; $positionNum ++) {
         //地点iのアルファベット、 道1の行き先番号、道2の行き先番号を取得する
         fscanf(STDIN, "%s %d %d", $alphabet, $direction1, $direction2);
         //配列に格納する['text' => アルファベット, 'root1' => 道1番号, 'root2' => 道2番号] - ①
         $positionInfo = [
             'alphabet'   => $alphabet,
             'direction1' => $direction1,
             'direction2' => $direction2,
         ];
         
         //配列①を配列に格納する [i => ①]
         $positions[$positionNum] = $positionInfo;
    }

    //移動の回数Kを取得
    
    //移動の数だけ繰り返す
    for ($k = 1; $k <= $moveCount; $k ++) {
        //現在地のアルファベットを、呪文の変数に文字列結合する
        $incantation .= $positions[$currentPosition]['alphabet'];
        //選択した道の番号を取得する - 1 or 2
        fscanf(STDIN, "%d", $selectedRoot);
        //次の地点を求める
        $nextPosition = $selectedRoot === 1 ? $positions[$currentPosition]['direction1'] : $positions[$currentPosition]['direction2'];
        //現在地を移動する
        $currentPosition = $nextPosition;
        
        if($k === $moveCount) {
            //最終地点のアルファベットも呪文に結合する
            $incantation .= $positions[$currentPosition]['alphabet'];
        }
    }
    

    //呪文と改行を出力する
    echo $incantation . "\n";
     
?>