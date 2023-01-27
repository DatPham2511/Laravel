<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'post_title', 'post_content', 'post_desc','post_status','post_slug','post_image'
    ];
    protected $primaryKey = 'post_id';
 	protected $table = 'tbl_post';
}
