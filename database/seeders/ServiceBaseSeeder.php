<?php

namespace Database\Seeders;

use App\Models\Service;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create(['title' => 'Магазин']);
        Service::create(['title' => 'Доставка']);
        Service::create(['title' => 'Приложение']);
    }
}
