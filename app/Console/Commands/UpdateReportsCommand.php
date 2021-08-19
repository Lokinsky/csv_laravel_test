<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;



class UpdateReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(\App\Http\Controllers\ReportsController $reportsController)
    {
        $reportsController->update_report_by_file();
    }
}
