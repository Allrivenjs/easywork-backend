<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class GitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Git auto deploy';

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
        try {
            //exec('git checkout cpanel-production');
            exec('git pull');
            exec('php composer install');
            $this->info('Command success');
        } catch (Exception $e) {
            Log::info($e);
        }
    }
}
