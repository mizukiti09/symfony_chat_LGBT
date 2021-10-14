## アプリケーション名
***
『　ちょい飲み!!　』
<br>
<br>

## アプリケーション作成意図?
***
日本では同性愛が認められつつあり、2015年に東京の渋谷区と世田谷区では同性カップルを自治体が証明したり、宣誓を受け付けたりなどできるようになりました。
昨今、出会い系webサービスが多いように思われますが、LGBTに向けたそのようなサービスはあまりないように思われます。
コアなジャンルですが、需要としては十分にあると考え出会い掲示板を作成するに当たりました。
<br>
<br>


## 似たようなサービス?
***  
### カナジョ
LGBT専用の出会い系webサービスです。このサービスの課題点を洗い出し、それを改善しアプリを作成する。
*課題点*
- エリアのソート機能が大まか。
- サービス内でのMessage機能が無く、UserプロフィールのMailアドレスを通じてやりとりをするので他の出会い系サービスと比べると手間がかかる。
- UserのMyPageが無い。投稿をするに当たりUser情報をいちいち入力しなければならない。
<br>

*改善案*
- エリアのソート機能を各都道府県別に出せるようにする。 
- Messageのpageを誰もが使っているLINEのように見立て使いやすい仕様にする。
- UserInfoのpageを作り編集など管理しやすいようにする。
<br>


## サービス概要
***
ユーザーは投稿User、ゲストUserに分けられる。
ゲストUserは気に入った投稿のMessageボタンを押し、Messageページへ移動しやりとりする。
やり取りした履歴はheaderのメッセージ一覧から確認できる。
投稿Userの場合は投稿者用メッセージリスト。
ゲストUserの場合はゲスト用メッセージリストから確認できる。

<br>
<br>

## 機能一覧
***
- User登録
- ログイン
- ログアウト
- 投稿機能
- 投稿一覧(ページネーション)
- エリア別ソート機能
- メッセージ一覧機能
<br>
<br>

## データベース
***
|  *Userテーブル*  | カラム名 | データ型 |
|:------:|:--------:|:--------:|
| ユーザーid | id  | integer |
| ユーザー名 | username | string |
| 年齢 | age | integer | 
| パスワード | password | string |
| メールアドレス | email | string |
| エリア | area | string |
| プロフ写メ | image | string |
| 性別 | sex | string |
| 見た目 | look | string |
| 退会してる<br>ユーザーかどうか | isActive | boolean |

<br>

| *Contributeテーブル* | カラム名 | データ型 | 外部キー制約 |
|:------:|:--------:|:--------:|:--------:|
| 投稿id | id  | integer | |
| 投稿 | textarea | string |  |
| 投稿者id | user_id | integer | Userテーブル |
| 作成日時 | created_at | datetime_immutable |
| 更新日時 | updated_at | datetime_immutable |

<br>

| *Bordテーブル* | カラム名 | データ型 | 外部キー制約 |
|:------:|:--------:|:--------:|:--------:|
| ボードid | id  | integer | 
| 投稿id | contribute_id | integer | Contributeテーブル |
| 投稿者id | user_id | integer | Userテーブル |
| 作成日時 | created_at | datetime_immutable |
| 更新日時 | updated_at | datetime_immutable |

<br>

| *Messageテーブル* | カラム名 | データ型 | 外部キー制約 |
|:------:|:--------:|:--------:|:--------:|
| メッセージid | id  | integer | 
| メッセージ | message | string |
| 受信者id | to_user_id | integer | Userテーブル |
| 送信者id | from_user_id | integer | Userテーブル |
| ボードid | bord_id | integer | Bordテーブル |
| 投稿id | contribute_id | integer | Contributeテーブル |
| 作成日時 | created_at | datetime_immutable |
| 更新日時 | updated_at | datetime_immutable |

<br>


## 使用開発ツール
***
- Symfony

## サービスを使用する準備として
ターミナルで npm install をしてください。

















