<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
    use HasFactory;
    protected $fillable = [
        'entrance_id',
        'floor_number'
    ];
    protected $casts = [
        'floor_number' => 'integer'
    ];
    public function entrance():BelongsTo
    {
        return $this->belongsTo(Entrance::class);
    }
    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }
}
