<?php

namespace App\Http\Controllers;

use App\Models\ApartmentType;
use App\Models\House;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function house(Request $request)
    {
        $rooms = $request->rooms;
        $type_room = $request->type_room;
        $square_in = $request->square_in;
        $square_out = $request->square_out;

        $house = House::with(['entrances.floors.apartments' => function ($query) use ($rooms, $type_room, $square_in, $square_out) {
            $query->when(!empty($rooms), function ($subquery) use ($rooms) {
                $subquery->whereIn('room_count', $rooms);
            })
                ->when(!empty($type_room), function ($subquery) use ($type_room) {
                    $subquery->where('apartment_type_id', $type_room);
                })
                ->when(!empty($square_in), function ($subquery) use ($square_in) {
                    $subquery->where('square', '>=', $square_in);
                })
                ->when(!empty($square_out), function ($subquery) use ($square_out) {
                    $subquery->where('square', '<=', $square_out);
                });
        }])
            ->first();

        $house->entrances->flatMap(function ($entrance) {
            return $entrance->floors->flatMap(function ($floor) use ($entrance) {
                return $floor->apartments->map(function ($apartment) use ($entrance, $floor) {
                    $apartment->entrance_number = $entrance->entrance_number;
                    $apartment->floor_number = $floor->floor_number;
                    $apartment->apartment_type_name = $apartment->apartmentType->type_name ?? null;
                    return $apartment;
                });
            });
        });

        $maxFloors = 0;

        foreach ($house->entrances as $entrance) {
            $numFloors = $entrance->floors->count();
            if ($numFloors > $maxFloors) {
                $maxFloors = $numFloors;
            }
        }


        $totalApartments = $house->entrances->flatMap(function ($entrance) {
            return $entrance->floors->flatMap(function ($floor) {
                return $floor->apartments;
            });
        })->count();

        $statusOneApartments = $house->entrances->flatMap(function ($entrance) {
            return $entrance->floors->flatMap(function ($floor) {
                return $floor->apartments->where('status', 1);
            });
        })->count();
        $statusTwoApartments = $house->entrances->flatMap(function ($entrance) {
            return $entrance->floors->flatMap(function ($floor) {
                return $floor->apartments->where('status', 2);
            });
        })->count();
        $statusThreeApartments = $house->entrances->flatMap(function ($entrance) {
            return $entrance->floors->flatMap(function ($floor) {
                return $floor->apartments->where('status', 3);
            });
        })->count();
        $statusFourApartments = $house->entrances->flatMap(function ($entrance) {
            return $entrance->floors->flatMap(function ($floor) {
                return $floor->apartments->where('status', 4);
            });
        })->count();


        $house->max_floors = $maxFloors;
        $house->total_apartments = $totalApartments;
        $house->total_free_apartments = $statusOneApartments;
        $house->total_booked_apartments = $statusTwoApartments;
        $house->total_sold_apartments = $statusThreeApartments;
        $house->total_unavailable_apartments = $statusFourApartments;



        return response()->json([
            'house' => $house
        ]);
    }
    public function type_room()
    {
        $type_rooms = ApartmentType::all();
        return response()->json([
           'type_rooms' => $type_rooms
        ]);
    }
}
