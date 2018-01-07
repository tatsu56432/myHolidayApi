<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
    protected $description = 'Command description';

    protected $db_host;
    protected $db_user;
    protected $db_pass;
    protected $db_name;
    protected $store_path;

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

//     $command = 'mysqldump -h '. $this->db_host .' -u '. $this->db_user .' -p'.$this->db_pass.' '.$this->db_name.'>'.$this->store_path.$this->db_name.'.sql';

        exec($command);

    }
}
