<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;
    protected $table = "inv_goods";
    public $timestamps = true;
    protected $fillable = [
        'name', 'price', 'stock'
    ];
    protected $dates = ['deleted_at'];
}
