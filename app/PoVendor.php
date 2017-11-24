<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoVendor extends Model
{
    protected $table = "po_vendors";
    public $timestamps = true;
    protected $fillable = [
        'name', 'email', 'phone', 'address'
    ];
}
