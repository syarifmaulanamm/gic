<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table = "inv_goods_in";
    public $timestamps = true;
    protected $fillable = [
        'goods_id', 'qty'
    ];
}
