<?php

namespace Database\Factories;

use App\Models\Entrance;
use App\Models\Floor;
use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrance>
 */
class EntranceFactory extends Factory
{
    protected $model = Entrance::class;

    public function definition()
    {
        static $entranceNumber = 1;

        return [
            'house_id' => House::factory(),
            'entrance_number' =>  $entranceNumber++,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Entrance $entrance) {
            Floor::factory()->count(rand(5, 14))->create(['entrance_id' => $entrance->id]);
        });
    }
}
