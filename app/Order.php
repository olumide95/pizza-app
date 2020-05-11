<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'menu_id', 'quantity','amount','user_id'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id','menu_id','user_id','order_id','created_at','updated_at'
    ];


    public function menu()
    {
       return $this->hasOne(Menu::class, 'id', 'menu_id');
    }


    public function delivery_info()
    {
       return $this->hasOne(DeliveryInfo::class, 'order_id', 'order_id');
    }
}
