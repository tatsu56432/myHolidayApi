

## MyHolidayAPI

laravelを用いて国民の祝日を返すwebAPIを作成していきます。

## 現状
- webブラウザから特定のURLにアクセスすると国民の祝日を返すAPIです。
- RESTfulAPIとして作成しています。    
http://yourApiDomain/api/v2/holidays/2018  
　にアクセスすると、2018年の国民の祝日一覧がjson形式で返ります。
http://yourApiDomain/api/v2/holidays/2018/5  
　にアクセスすると、2018年5月の国民の祝日一覧がjson形式で返ります。
http://yourApiDomain/api/v2/holidays/2018/5/5  
　にアクセスすると、2018年5月5日が国民の祝日かどうか返します。

## 祝日のデータ取得
国民の祝日データの取得は[内閣府のホームページ](http://www8.cao.go.jp/chosei/shukujitsu/gaiyou.html)で配布しているCSVファイルから取得します。
内閣府のホームページからのCSVファイルの取得に失敗したら、アプリケーション内で保持しているCSVをロードするようになっています。
ですので国民の祝日データはCSVファイルに記載されているデータに由来します。(2018年1月28日現在、CSVファイルに記載されているデータ年数は2016年~2018年までです。)  
毎日（深夜0時）にDBのバックアップを行い、かつDBの更新を自動で行うようになっています。
またDBのバックアップと既存のダンプデータの削除に失敗した場合、管理者にメールが送信されるようになっています。


## DBの更新方法
laravelのタスクスケジューラを用い、artisanコマンドを実行させることによりDBのアップデートを自動で行います。
laravelのタスクスケジューラを起動するには/etc/cron.d/に以下のCronエントリを追加する必要があります。

'* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1'

タスクスケジューラは/myapi/app/Console/Kernel.phpに定義していますので、そちらをご参照ください。


## 参考にしたページのURL
- [Laravel 5.3 通知](https://readouble.com/laravel/5.3/ja/notifications.html)
- [Laravel 5.3 タスクスケジュール](https://readouble.com/laravel/5.3/ja/scheduling.html)
- [内閣府のホームページ](http://www8.cao.go.jp/chosei/shukujitsu/gaiyou.html)
- [DBに格納するCSVファイル](http://www8.cao.go.jp/chosei/shukujitsu/syukujitsu.csv)




