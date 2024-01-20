<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Status::create([
             'slug' => 'pending' ,
             'name' => 'В ожидании '
         ]);
         Status::create([
             'slug' => 'preparing' ,
             'name' => 'В работе'
         ]);
         Status::create([
             'slug' => 'paid' ,
             'name' => 'Расчет'
         ]);
         Status::create([
             'slug' => 'completed' ,
             'name' => 'Выполнен'
         ]);
         Status::create([
             'slug' => 'shipped' ,
             'name' => 'Отгружен'
         ]);
         Status::create([
             'slug' => 'cancelled' ,
             'name' => 'Отменен'
         ]);
    }
}
