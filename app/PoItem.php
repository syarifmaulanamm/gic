<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoItem extends Model
{
    protected $table = "po_items";
    public $timestamps = true;
    protected $fillable = [
        'po_id', 'name', 'quantity', 'price', 'amount'
    ];
}
