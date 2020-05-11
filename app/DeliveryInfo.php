<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryInfo extends Model
{
    protected $table = 'delivery_info';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id','user_id','delivery_address', 'customer_name','customer_phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id','user_id','updated_at'
    ];


    public function order()
    {
       return $this->hasMany(Order::class, 'order_id', 'order_id')->with('menu:id,name,image');
    }
}
