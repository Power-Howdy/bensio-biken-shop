# メルマガ管理プラグイン

[![Build Status](https://travis-ci.org/EC-CUBE/mail-magazine-plugin.svg?branch=master)](https://travis-ci.org/EC-CUBE/mail-magazine-plugin)
[![Build status](https://ci.appveyor.com/api/projects/status/3j9pol5x153eol6c?svg=true)](https://ci.appveyor.com/project/ECCUBE/mail-magazine-plugin)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f4bd9bd6-56ca-4a8f-a274-1fc13ca9ef98/mini.png)](https://insight.sensiolabs.com/projects/f4bd9bd6-56ca-4a8f-a274-1fc13ca9ef98)
[![Coverage Status](https://coveralls.io/repos/github/EC-CUBE/mail-magazine-plugin/badge.svg?branch=master)](https://coveralls.io/github/EC-CUBE/mail-magazine-plugin?branch=master)

## 概要
会員に向けメルマガの配信を行うためのプラグインです。  
テンプレート機能、配信履歴の管理を行えます。   
HTML形式のメルマガ配信も可能です。

## フロント画面

### F1:メールマガジン受信設定
会員登録時にメールマガジンの受信有無を選択可能。  
Myページの会員登録内容変更で設定の変更が可能。

- 受け取る
- 希望しない

----

## 管理画面

### A1:会員管理画面でのメールマガジン受信設定
- 受け取る
- 希望しない

### A2:メルマガ配信

#### A2-1:配信先設定
検索条件に一致した会員を配信先に設定する

|検索条件|備考|
|---|---|
|会員ID||
|会員種別|仮会員/本会員|
|都道府県||
|お名前||
|お名前(フリガナ)||
|性別||
|誕生月||
|誕生日|開始日〜終了日|
|メールアドレス||
|携帯メールアドレス||
|電話番号||
|職業|複数選択可能|
|合計購入金額|最低金額〜最高金額|
|合計購入回数|最低購入回数〜最高購入回数|
|登録日・更新日|開始日〜終了日|
|最終購入日|開始日〜終了日|
|購入商品名||
|購入商品コード||
|カテゴリ||
|配信形式|・HTML+TEXT<br>・HTML<br>・TEXT<br>・全員(メルマガ拒否会員含む)|
|配信メールアドレス種別|・PCメールアドレス<br>・携帯メールアドレス<br>・PCメールアドレス(携帯メールアドレスを登録している会員は除外)<br>・携帯メールアドレス(PCメールアドレスを登録している会員は除外)|

##### A2-2:配信内容設定
テンプレートを選択し、配信内容を編集する。  
multipart/alternative形式のメールマガジン配信が可能。  
`{name}`と入力した場合は、配信時に会員の名前に置き換わる。  

- タイトル
- TEXT形式
- HTML形式


##### A2-3:メルマガ配信
設定した配信内容を配信先に配信する。  
すべての配信先へメール送信完了後、管理者宛に送信完了メールを送信する。  
配信前に、任意のアドレス宛へのテスト配信が可能。  

### A3:テンプレート管理
メールマガジンのテンプレートを登録/更新/削除/プレビューできる。

テンプレート内容

|項目名|必須|備考|
|---|:---:|---|
|メール形式|○|HTML/テキスト|
|タイトル|○|{name}を名前に変換する|
|本文(TEXT形式)|○|{name}を名前に変換する|
|本文(HTML形式)|-|{name}を名前に変換する|

### A4:メルマガ配信履歴管理
配信したメールマガジンの履歴を確認/再試行/削除できる。

配信履歴内容

- 配信開始時刻
- 配信終了時刻
- タイトル
- 本文
- 配信条件
- 配信総数
- 配信済数
- 配信失敗数
- 未配信数

#### A4-1:配信条件の確認
メルマガ送信時に使用した検索条件を確認できる。

#### A4-2:失敗した場合の再送信ができる
失敗した送信先に再度配信を実行する。

#### A4-3:配信結果の確認
送信したあて先のリストを閲覧できる。  
あて先ごとに、送信成功/失敗を確認することができる。

