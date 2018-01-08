

##MyHolidayAPI

laravelを用いて国民の祝日を返すwebAPIを作成していきます。

## 現状
- webブラウザから特定のURLにアクセスすると国民の祝日を返すAPIです。
- RESTfulAPIとして作成しています。    
（http://153.121.58.103/api/v2/holidays/2018　にアクセスすると、2018年の国民の祝日一覧がjson形式で返ります。）

## 祝日のデータ取得
国民の祝日データの取得は[内閣府のホームページ](http://www8.cao.go.jp/chosei/shukujitsu/gaiyou.html)で配布しているCSVファイルから取得します。
内閣府のホームページからのCSVファイルの取得に失敗したら、アプリケーション内で保持しているCSVをロードするようになっています。
毎日（深夜0時）にDBのバックアップを行い、かつDBの更新を自動で行うようになっています。


## DBの更新方法
laravelのタスクスケジューラを用い、artisanコマンドを実行させることによりDBのアップデートを自動で行います。
laravelのタスクスケジューラを起動するには/etc/cron.d/に以下のCronエントリを追加する必要があります。

'* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1'

タスクスケジューラは/myapi/app/Console/Kernel.phpに定義していますので、そちらをご参照ください。

##参考にしたページのURL
- [Laravel 5.3 通知](https://readouble.com/laravel/5.3/ja/notifications.html)
- [Laravel 5.3 タスクスケジュール](https://readouble.com/laravel/5.3/ja/scheduling.html)
- [内閣府のホームページ](http://www8.cao.go.jp/chosei/shukujitsu/gaiyou.html)
- [DBに格納CSVファイル](http://www8.cao.go.jp/chosei/shukujitsu/syukujitsu.csv)




