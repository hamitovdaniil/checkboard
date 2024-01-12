<?php

namespace Database\Factories;

use App\Models\Entrance;
use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    protected $model = House::class;

    public function definition()
    {
        return [
            'house_name' => 'Golden House',
        ];
    }
    public function configure()
    {
       return $this->afterCreating(function (House $house){
           Entrance::factory()->count(4)->create(['house_id' => $house->id]);
       });
    }
}
