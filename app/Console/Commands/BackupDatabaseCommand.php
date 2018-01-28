<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//use App\Http\Requests;
use Mail;
use App\Mail\HogeShipped;
use App\Mail\OrderShipped;
use App\Mail\NoteDumpResult;

class BackupDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:backupdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'store DataBase dump data';

    protected $db_host;
    protected $db_user;
    protected $db_pass;
    protected $db_name;
    protected $store_path;
    protected $admin_user_mail_from;
    protected $admin_user_mail;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->db_host = env('DB_HOST');      // DBホスト
        $this->db_user = env('DB_USERNAME');  // DBユーザ
        $this->db_pass = env('DB_PASSWORD');  // DBパスワード
        $this->db_name = env('DB_DATABASE');  // バックアップ対象スキーマ
        $this->store_path = '/tmp';           // 保存先ディレクトリ
        $this->admin_user_mail_from = env('ADMIN_USER_MAIL_FROM'); //from用管理者用メールアドレス
        $this->admin_user_mail = env('ADMIN_USER_MAIL'); //管理者用メールアドレス

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // ファイル名
        $file_name = sprintf('%s.sql', date('YMDHis'));
        // ファイルフルパス
        $file_path = sprintf('%s/%s', $this->store_path, $file_name);


        $command = sprintf(
            'mysqldump -h %s -u %s -p%s %s > %s',
            $this->db_host,
            $this->db_user,
            $this->db_pass,
            $this->db_name,
            $file_path
        );

        $execFailed = null;
        $execRemoveDbFailed = null;

        $commandRemoveDbBackup = sprintf('rm -f /tmp/*.sql');


        exec($commandRemoveDbBackup, $output, $execRemoveDbFailed);
        exec($command, $output, $execFailed);
//        $command = 'mysqldump -h '. $this->db_host .' -u '. $this->db_user .' -p'.$this->db_pass.' '.$this->db_name.'>'.$this->store_path.$this->db_name.'.sql';


        if ($execFailed) {
            $options = [
                'from' => $this->admin_user_mail_from,
                'from_jp' => 'no-reply',
                'to' => $this->admin_user_mail,
                'subject' => '国民の祝日APIのDBのバックアップに失敗しました。',
                'template' => 'email.dumpFailed', // resources/views/emails/hoge/mail.blade.php
            ];

            $data = [
                'text' => "国民の祝日APIのDBのバックアップに失敗しました。DBの状態を確認してください。",
            ];

            Mail::to($options['to'])->send(new HogeShipped($options, $data));

        } elseif($execRemoveDbFailed) {
            $options = [
                'from' => $this->admin_user_mail_from,
                'from_jp' => 'no-reply',
                'to' => $this->admin_user_mail,
                'subject' => 'DBのバックアップファイルの削除が失敗しました。',
                'template' => 'email.hoge.mail',
            ];

            $data = [
                'text' => 'DBのバックアップファイルの削除が失敗しました。/tmpディレクトリ内のバックアップファイルの確認をお願いします。',
            ];

            Mail::to($options['to'])->send(new OrderShipped($options, $data));
        }
    }
}
