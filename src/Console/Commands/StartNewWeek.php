<?php

namespace Sty\Hutton\Console\Commands;

use Illuminate\Console\Command;

use Sty\Hutton\Http\Service\GenerateNewWeeks;

class StartNewWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:joiner-weeks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Starting Joiners New Week';

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
    public function handle()
    {
        GenerateNewWeeks::newWeeks();
    }
}
