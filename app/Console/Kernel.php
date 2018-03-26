<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\KronoxSession;
use App\Models\SchedulledBooking;
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
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            foreach (KronoxSession::all() as $session) {
                $session->poll();
            }
        })->everyFifteenMinutes();

        $schedule->call(function () {
            $toBook = SchedulledBooking::where('date', Carbon::now('Europe/Stockholm')->addWeek()->toDateString())->get();
            $dateString = Carbon::now('Europe/Stockholm')->toDayDateTimeString();
            \Log::Info("Run Schedulled bookings at: " . $dateString);
            foreach ($toBook as $booking) {
                $booking->book();
            }
        })->daily();
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
