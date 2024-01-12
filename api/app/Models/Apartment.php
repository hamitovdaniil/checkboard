<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = [
        'floor_id',
        'apartment_type_id',
        'square',
        'status',
        'room_count',
    ];

    protected $casts = [
        'floor_id' => 'integer',
        'apartment_type_id' => 'integer',
        'square' => 'integer',
        'status' => 'integer',
        'room_count' => 'integer',
    ];

    const FREE_ROOM = 1;
    const BOOKED_ROOM = 2;
    const SOLD_ROOM = 3;
    const UNAVAILABLE_ROOM = 4;

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }
    public function apartmentType(): BelongsTo
    {
        return $this->belongsTo(ApartmentType::class, 'apartment_type_id');
    }


}
