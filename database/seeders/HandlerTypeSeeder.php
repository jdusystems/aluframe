<?php

namespace Database\Seeders;

use App\Models\HandlerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HandlerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HandlerType::create([
            'name' => "Снизу" ,
            'slug' => 'below'
        ]);
        HandlerType::create([
            'name' => "Сверху" ,
            'slug' => 'top'
        ]);
        HandlerType::create([
            'name' => "Без ручки" ,
            'slug' => 'no_handler'
        ]);
        HandlerType::create([
            'name' => "По кругу" ,
            'slug' => 'round'
        ]);
        HandlerType::create([
            'name' => "Напротив петель" ,
            'slug' => 'opposite'
        ]);

    }
}
