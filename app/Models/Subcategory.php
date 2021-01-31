<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $casts = [
        'created_at' => 'timestamp:Y-m-d H:i:s',
    ];
    
    protected $timestamp=false;


    protected $fillable = [
        'category_id',
        'category_title',
        'subcategory_title',
        'subcategory_description',
        'is_active',
    ];
    
    
    public static $rules    = [
        'category_id'       => 'required|integer',
        'subcategory_title' => 'required|string|unique:subcategories,subcategory_title,:id',
        'is_active'         => 'required|integer',
    ];


    public static $msg      = [
        'category_id.required'          => 'Category is required!',
        'subcategory_title.required'    => 'Subcategory Title is required!',
        'subcategory_title.string'      => 'Subcategory Title must be type of `string`!',
        'subcategory_title.unique'      => 'Subcategory Title already exists!',
        'category_description.string'   => 'Subcategory description must be type of `string`!',
    ];


    public $accessable_field=[
        'category_id',
        'category_title',
        'subcategory_title',
        'subcategory_description',
        'is_active',
    ];

    public function categories()
    {
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
}
