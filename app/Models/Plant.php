<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [       
        'farmer_id',
        'remain_plant',
        'addon_plant',
        'addon_species',
        'quantity_for_sale',
        'date_for_sale',
    ];

    public function farmers() {
        return $this->belongsTo(Farmer::class, 'farmer_id');
    }
}
