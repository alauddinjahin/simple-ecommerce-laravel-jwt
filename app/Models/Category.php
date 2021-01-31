<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $casts = [
        'created_at' => 'timestamp:Y-m-d H:i:s',
    ];
    
    protected $timestamp=false;


    protected $fillable = [
        'category_title',
        'category_description',
        'is_active',
    ];
    
    
    public static $rules    = [
        'category_title'    => 'required|string|unique:categories,category_title,:id',
        'is_active'         => 'required|integer',
    ];


    public static $msg      = [
        'category_title.required'       => 'Category Title is required!',
        'category_title.string'         => 'Category Title must be type of `string`!',
        'category_title.unique'         => 'Category Title already exists!',
        'category_description.string'   => 'Category description must be type of `string`!',
    ];


    public $accessable_field=[
        'category_title',
        'category_description',
        'is_active',
    ];


    
}
