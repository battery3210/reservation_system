<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stylist extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'stylists';

    public function scopeActive($query){
        return $query->where('delete_flg',false)->orderBy('created_at','desc');
    }


}
