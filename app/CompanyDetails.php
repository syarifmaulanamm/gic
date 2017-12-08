<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDetails extends Model
{
    use SoftDeletes;
    protected $table = "sales_company_details";
    public $timestamps = true;
    protected $fillable = [
        'sales_client_id', 'pic' 
    ];
    protected $dates = ['deleted_at'];
}
