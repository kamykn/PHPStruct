# PHPStruct
[![Build Status](https://travis-ci.org/kamykn/phpstruct.svg?branch=master)](https://travis-ci.org/kamykn/phpstruct)


## 対応していないこと
- メンバー変数のstaticな呼び出し(プロパティがunsetされる影響で)
- public,protectedの使い分けは指定はできるけど、全てパブリックのようになる
- privateは継承もとからも参照できないので、classに残る。外からは__set、__getでもサワレナイ。
	- つまり、型は保てない
	- trait実装のほうが良い？

## 実装内容
非常にPHPらしい方法をとっているかもしれない
メンバー変数を根こそぎ消して、配列に詰め替えている。
PHPのClassをStruct風にするという記事ではprotectedにして、見えるけどアクセスできないような形が多い。
ならば、いっそ削除してしまえと。

なお、protectedで残しておくと、メソッドから自由に触り放題なので、型の維持ができなくなる可能性がある。

PHP7から使えるstrictもある。あれはプリミティブ型をサポートしているが、クラスは…？

ライブラリのヤツ。1回目と2回目で呼び出しが変わる？

## 例

```
Usage:

class User extends Struct
{
    public $userId      = Struct::INT;    // This is int.
    public $accountName = Struct::STRING; // This is string.
    public $free        = Struct::ANY;    // This is "any" type.
}

$user = New User([
    'userId'      => 10,
    'accountName' => 'jon',
]);

$user->accountName = 'bob';
echo $user->accountName; // #=> bob

$user->accountName = 12345;   // #=> Uncaught Exception: Trying to set a different type.
$user->accountName = '12345';
echo $user->accountName; // #=> 12345

// Anyプロパティは今までのpropertyと同じでなんでも入れられる
$user->free = 'kamykn';
echo $user->free;
$user->free = 12345;
echo $user->free;

// 初期値を決める場合はそのまま値を入れる
class User extends Struct
{
    public $userId = 0;       // This is int.
    public $accountName = ''; // This is string.
    public $free;             // NULL is for "any" type.
}
```

# ArrayAbjectを使えば配列形式だけど、getとsetに全てフックできるかもしれない。
https://qiita.com/metheglin/items/62d8fa527b6b08099d3b
https://qiita.com/metheglin/items/87e25bbdf37fbe0cd6e2

testに添字アクセスを追加
なんか、オブジェクトも添え字でアクセスできるって書いてある
http://www.php.net/manual/ja/sdo.sample.getset.php
あれ、てことはArrayAbjectを使えば配列形式だけどアロー演算子でアクセスできる？


