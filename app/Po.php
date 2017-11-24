<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Po extends Model
{
    use SoftDeletes;
    protected $table = "po";
    public $timestamps = true;
    protected $fillable = [
        'title', 'tax', 'total', 'issued_by', 'status'
    ];
    protected $dates = ['deleted_at'];

    public function vendor()
    {
        return $this->belongsTo('App\PoVendor', 'vendor_id');
    }
}
