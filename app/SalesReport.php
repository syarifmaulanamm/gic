<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    protected $table = "sales_report";
    public $timestamps = true;
    protected $fillable = [
        'report_type', 'subject', 'gross', 'netto', 'profit'
    ];
}
