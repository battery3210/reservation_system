<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    protected $table = 'customers';

    public function scopeActive($query,$colums = ['*']){
        return $query->select($colums)->where('delete_flg',false)->orderBy('created_at','desc');
    }

}
