<?php

namespace App\Console;

use App\Models\Site\Mailling;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Price\CurrencyController;
use App\Http\Controllers\Mailling\MaillingController;
use App\Events\MaillingForRegister;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*Обновляем Курсы Валют*/
        $schedule->call(function ()
        {
            $cur = New CurrencyController();

            $cur->getCur();

        })->daily();

        /*Отправка рассылок клиентам*/
        $schedule->call(function ()
        {
            $maillingModel = new Mailling();

            $maillingController = New MaillingController($maillingModel);

            $maillings = $maillingModel->getActiveMaillings();

            $timestampNow = round((time()+10800)/60)*60;

            foreach ($maillings as $mailling) {

                $timestampEvent = round( $mailling->timestamp/60)*60;

                Storage::put('file.txt', $timestampNow . ' - ' . $timestampEvent . ' - ' . $mailling->timestamp);

                if ($timestampNow === $timestampEvent) {
                    event(new MaillingForRegister($mailling));
                }
            }


        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
