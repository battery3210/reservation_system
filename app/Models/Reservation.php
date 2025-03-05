<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'reservation_datetime',
        'stylist_id',
        'customer_id',
    ];

    public function stylist() {
        return $this->belongsTo(Stylist::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
