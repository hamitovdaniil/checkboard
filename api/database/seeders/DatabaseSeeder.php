<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ApartmentType;
use App\Models\Entrance;
use App\Models\House;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['type_name' => 'Коммерческое помещение'],
            ['type_name' => 'Жилое помещение']
        ];
        foreach ($items as $item){
            ApartmentType::create($item);
        }
        House::factory()->create();
    }
}
