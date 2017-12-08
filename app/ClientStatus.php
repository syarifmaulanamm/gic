<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientStatus extends Model
{
    use SoftDeletes;
    protected $table = "sales_client_status";
    public $timestamps = true;
    protected $fillable = [
        'classification', 'name_of_company' 
    ];
    protected $dates = ['deleted_at'];
}
