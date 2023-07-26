<?php

namespace Database\Seeders;


use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data =json_decode( Http::get('https://www.datos.gov.co/resource/xdk5-pm3f.json')
            ->body(), JSON_UNESCAPED_UNICODE);
        $colombia = Country::create([
            'name' => 'Colombia',
        ]);
        $states = [];
        $aux = '';
        collect($data)->each(function ($item,$key) use (&$states, &$aux) {
//           echo json_encode($item, JSON_UNESCAPED_UNICODE) . $key + 1 . PHP_EOL;
           if($aux != $item['departamento'] && !array_key_exists($item['departamento'], $states)){
               $states[$item['departamento']] = [
                   'name' => $item['departamento'],
                   'created_at' => now(),
                   'updated_at' => now(),
                   'cities'=>[
                       [
                           'name' => $item['municipio'],
                           'created_at' => now(),
                           'updated_at' => now(),
                       ]
                   ]
               ];
           }else{
               $states[$item['departamento']]
               ['cities'] = array_merge($states[$item['departamento']]['cities'],[
                   [
                       'name' => $item['municipio'],
                       'created_at' => now(),
                       'updated_at' => now(),
                   ]
               ]);
           }
           $aux = $item['departamento'];
        });
        //echo 'Inserting ' . count($states) . ' states...' . PHP_EOL;
        $states = collect($states);
        //echo 'Inserting ' . $states->sum(function ($item) {
        //    return count($item['cities']);
        //}) . ' cities...' . PHP_EOL;
        //sleep(1);

        $states->each(function ($item) use ($colombia) {
            //echo 'For each state ' . $item['name'] . ' with ' . count($item['cities']) . ' cities' . PHP_EOL;
            $city = $colombia->states()->create([
                'name' => $item['name']
            ]);
            collect($item['cities'])->each(function ($item) use ($city) {
              //  echo 'For each city ' . $item['name'] . PHP_EOL;
                $city->cities()->create($item);
            });
            //echo 'State ' . $item['name'] . ' with ' . count($item['cities']) . ' cities inserted in the database' . PHP_EOL;
        });


//        echo 'All states inserted in the database' . PHP_EOL;

    }
}
