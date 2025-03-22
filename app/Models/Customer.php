<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ModelではなくAuthenticatableを継承するように変更
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // API認証用（APIを使わないなら不要）

class Customer extends Authenticatable
{
    //
    // use HasFactory,Notifiable,HasApiTokens; // トレイトを追加
    use HasFactory,Notifiable; // トレイトを追加

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_member',
        'delete_flg'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function scopeActive($query,$colums = ['*']){
        return $query->select($colums)->where('delete_flg',false)->orderBy('created_at','desc');
    }

}
