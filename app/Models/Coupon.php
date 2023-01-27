<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'coupon_name', 'coupon_code', 'coupon_quantity','coupon_number', 'coupon_condition','coupon_status','coupon_date_start','coupon_date_end'
    ];
    protected $primaryKey = 'coupon_id';
 	protected $table = 'tbl_coupon';
}
