<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CunrrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            'usd',
            'cop',
            'eur',
            'gbp',
            'jpy',
        ];

        foreach ($currencies as $currency) {
            Currency::create([
                'iso' => $currency,
            ]);
        }
    }
}
