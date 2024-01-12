<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\ApartmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    protected $model = Apartment::class;
    public function definition()
    {
        $apartment_type_id = ApartmentType::inRandomOrder()->take(1)->pluck('id');
        $square = rand(10, 100);
        $status = rand(1, 4);
        $room_count = rand(1, 4);
        return [
            'floor_id' => Apartment::factory(),
            'apartment_type_id' => $apartment_type_id->first(),
            'square' => $square,
            'status' => $status,
            'room_count' => $room_count
        ];
    }
}
