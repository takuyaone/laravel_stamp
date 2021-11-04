## 模擬案件シート
https://docs.google.com/spreadsheets/d/15o7wqgH5Mz7Vt6Q8c_0Uujuna4FBmbdlSwtKMbs9rSI/edit#gid=1908234755

## プロダクト概要
企業向け勤怠管理システムになります。
認証機能によりユーザー登録(社員登録)をして日々の出退勤打刻を行えます。
休憩時間については勤務中であれば何度でも取得できます。
また日々の勤務一覧も参照できる仕様になっています。
## 認証機能 Laravel Breeze インストール方法(windows)
認証機能はLaravel Breezeを採用しています。下記インストール方法です。

まずはマイグレートを実行して、予め用意されているテーブルをDBに作成。
php artisan migrate

次にcomposerを使ってlaravel/breezeパッケージを追加。
composer require laravel/breeze --dev

追加したbreezeをインストール。
php artisan breeze:install

最後にNode.jsモジュールのインストールとアセットのコンパイルを実行したら完了。
npm install
npm run dev

##

