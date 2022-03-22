<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [       
        'enterprise_id',
        'date_for_sell',
        'quantity_for_sell',
    ];

    public function enterprise() {
        return $this->belongsTo(Enterprise::class, 'id');
    }
}
