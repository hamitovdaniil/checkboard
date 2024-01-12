<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApartmentType extends Model
{
    use HasFactory;

    protected $fillable = ['type_name'];

    public function apartment(): HasOne
    {
        return $this->hasOne(Apartment::class);
    }

}
