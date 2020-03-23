<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hits the url and appends a log data in log file';

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
     * @return mixed
     */
    public function handle()
    {
        exec("curl -XGET 'http://localhost:8000'");
        echo "executed\n";
    }
}
