<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'info_fanpage', 'info_map', 'info_contact','info_logo','info_slogan'
    ];
    protected $primaryKey = 'info_id';
 	protected $table = 'tbl_information';
}
