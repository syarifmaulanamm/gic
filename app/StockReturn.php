<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockReturn extends Model
{
    protected $table = "inv_goods_return";
    public $timestamps = true;
    protected $fillable = [
        'inv_goods_out_id', 'qty'
    ];
}
