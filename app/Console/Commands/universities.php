<?php

namespace App\Console\Commands;

use App\Models\university;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class universities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'university:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate all universities around the world and store in the database';

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
        $response = file_get_contents(__DIR__.'/../../../public/assets/universities.json');

        $universities = json_decode($response);
        $no_if_universities = count($universities);
        if (university::all()->count() <= 0){
            for ($i =0; $i < $no_if_universities; $i++){
                $name= preg_replace("/[\r\n|\n|\r]+/", " ", $universities[$i]->data);
                university::create([
                    'name'=>  $name
                ]);
                $c = $name;
                $this->info("Creating new records: $c... $i ");
            }
        }else{
            $count = university::all()->count();
            $this->info("Records found.");
            $this->info("Deleting $count records...");
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            university::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        if (university::all()->count() <= 0) {
            for ($i = 0; $i < $no_if_universities; $i++) {
                $name= preg_replace("/[\r\n|\n|\r]+/", " ", $universities[$i]->data);
                university::create([
                    'name' =>  $name
                ]);
                $c = $name;
                $this->info("Creating new records: $c... $i ");
            }
        }
        $this->info("All universities generated and saved successfully");
        return 0;
    }

}
