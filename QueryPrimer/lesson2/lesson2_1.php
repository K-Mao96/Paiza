<?php

/**
 * piza「クエリメニュー」
 * Vtuber
 * STEP: 1 アイドルグループ
 * @link https://paiza.jp/works/mondai/query_primer/query_primer__idle_group/edit?language_uid=php
 */


//====クラス定義start

// メンバークラス
class Member {
    public function __construct(public string $name, public bool $isLeft = false)
    {}

    // 脱退する
    public function leave() {
        $this->isLeft = true;
    }

    // 名前を返す
    public function getName() {
        return $this->name;
    }

    // 在籍状況を返す
    public function isExist() {
        return !$this->isLeft;
    }
}

// メンバーリストクラス
class MemberList {
    public function __construct(public array $list = [])
    {}

    // 新メンバー追加
    public function addMember(member $member) {
        $name = $member->getName();
        $this->list[$name] = $member;
    }

    // 指定されたメンバーを返す
    public function callMember(member $member) {
        $name = $member->getName();
        return $this->list[$name];
    }

    // 脱退メンバーを削除
    public function deleteMember(member $member) {
        $targetMember = $this->callMember($member);
        $targetMember->leave();
    }

    // メンバーの名前を辞書順にソート
    public function sort() {
        ksort($this->list);
    }

    // 在籍メンバーの名前を出力する
    public function outPut() {
        $this->sort();
        foreach ($this->list as $member) {
            if ($member->isExist()) {
                echo $member->getName();
                // 末尾に改行を入れる
                echo "\n";
            }
        }
    }
}

//====クラス定義end

// 初期メンバー数、イベントの回数を定義
fscanf(STDIN, "%d %d", $N, $K);

// メンバーリスト
$memberList = new MemberList();
for ($i=0; $i<$N; $i++) {
    fscanf(STDIN, "%s", $name);
    // メンバー
    $member = new Member($name);
    $memberList->addMember($member);
}

// イベントを実行
for ($i=0; $i<$K; $i++) {
    fscanf(STDIN, "%s %s", $event, $name);

    switch ($event) {
        case 'join':
            $newMember = new Member($name);
            $memberList->addMember($newMember);
            break;
        case 'leave':
            $targetMember = new Member($name);
            $memberList->deleteMember($targetMember);
            break;
        case 'handshake':
            $memberList->outPut();
    }

}


?>