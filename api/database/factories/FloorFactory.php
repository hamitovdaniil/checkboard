<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\Entrance;
use App\Models\Floor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Floor>
 */
class FloorFactory extends Factory
{
    protected $model = Floor::class;

    public function definition()
    {
        static $floorNumber = 1;
        static $lastEntranceId;
        return [
            'entrance_id' => Entrance::factory(),
            'floor_number' => function (array $attributes) use (&$floorNumber, &$lastEntranceId) {
                if ($attributes['entrance_id'] !== $lastEntranceId) {
                    $floorNumber = 1;
                    $lastEntranceId = $attributes['entrance_id'];
                }

                return $floorNumber++;
            },
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Floor $floor){
            Apartment::factory()->count(rand(2, 4))->create([
                'floor_id'=>$floor->id
            ]);
        });
    }
}
