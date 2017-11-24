<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $table = "inv_goods_out";
    public $timestamps = true;
    protected $fillable = [
        'goods_id', 'pic', 'qty'
    ];
}
