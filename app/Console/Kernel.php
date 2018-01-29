<?php

namespace App\Console;

use App\Console\Commands\BackupDatabaseCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BackupDatabaseCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //DBのバックアップ
        $schedule->command('command:backupdb')->daily();

        //スケジューラーでDBセットアップ用のartisanコマンドを実行
//        $schedule->command('migrate:rollback')->everyMinute();
//        $schedule->command('migrate:refresh')->everyMinute();
        $schedule->command('db:seed')->daily();

        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
