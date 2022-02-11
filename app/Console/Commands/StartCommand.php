<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

class StartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:system {--reset : reset database and run seed}
    {--host= : Created serve with custom host [default "127.0.0.1"]} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to initialize server from 0 or run server';

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

        if ($this->option('reset')){
            $this->alert('Start migrations and seeds');
            $this->call('migrate:fresh', [
                '--seed'=>'default'
            ]);
            $this->call('storage:link',[
                '--force'=>'default'
            ]);
            $this->alert('finished migrations and seeds');
            $this->alert('Creating keys of passport');
            $this->call('passport:install');
            $this->alert('Done');
        }
        $this->alert('Running serve');
        if ($this->option('host')){
            $this->info('Server custom');
            $this->call('serve',[
                '--host'=>$this->option('host'),'--port'=> 8000
            ]);
        }else{
            $this->info('Server default');
            $this->call('serve',[
                '--host'=>'127.0.0.1', '--port'=> 8000
            ]);
        }



    }
}
